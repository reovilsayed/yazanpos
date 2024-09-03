import dayjs from "dayjs";
import React, { useCallback, useEffect, useMemo, useState } from "react";

export const DateFilterRangeList = [
    {
        name: "Today",
        getValue: () => {
            const startDate = dayjs().startOf("day");
            const endDate = dayjs().endOf("day");
            return [startDate, endDate];
        },
    },
    {
        name: "Yesterday",
        getValue: () => {
            const startDate = dayjs().subtract(1, "day").startOf("day");
            const endDate = dayjs().subtract(1, "day").endOf("day");
            return [startDate, endDate];
        },
    },
    {
        name: "Last 7 days",
        getValue: () => {
            const startDate = dayjs().subtract(7, "day").startOf("day");
            const endDate = dayjs().endOf("day");
            return [startDate, endDate];
        },
    },
    {
        name: "Last 30 days",
        getValue: () => {
            const startDate = dayjs().subtract(30, "day").startOf("day");
            const endDate = dayjs().endOf("day");
            return [startDate, endDate];
        },
    },
    {
        name: "This week",
        getValue: () => {
            const startDate = dayjs().subtract(7, "day").startOf("day");
            const endDate = dayjs().endOf("day");
            return [startDate, endDate];
        },
    },
    {
        name: "Last week",
        getValue: () => {
            const startDate = dayjs().subtract(7, "day").startOf("day");
            const endDate = dayjs().endOf("day");
            return [startDate, endDate];
        },
    },
    {
        name: "This month",
        getValue: () => {
            const startDate = dayjs().startOf("month");
            const endDate = dayjs().endOf("month");
            return [startDate, endDate];
        },
    },
    {
        name: "Last month",
        getValue: () => {
            const startDate = dayjs().subtract(1, "month").startOf("month");
            const endDate = dayjs().subtract(1, "month").endOf("month");
            return [startDate, endDate];
        },
    },
    {
        name: "Year-to-date",
        getValue: () => {
            const startDate = dayjs().startOf("year");
            const endDate = dayjs().endOf("day");
            return [startDate, endDate];
        },
    },
    {
        name: "Last year",
        getValue: () => {
            const startDate = dayjs().subtract(1, "year").startOf("year");
            const endDate = dayjs().subtract(1, "year").endOf("year");
            return [startDate, endDate];
        },
    },
    {
        name: "All time",
        getValue: () => {
            const startDate = dayjs("2021-01-01", "YYYY-MM-DD").startOf("year");
            const endDate = dayjs().endOf("day");
            return [startDate, endDate];
        },
    },
];
export default function useCalenderFilter({ containerId }) {
    // const [calenderFilter, setCalenderFilter] = useState(DateFilterRangeList[0]);
    const [calenderFilter, setCalenderFilter] = useState(
        DateFilterRangeList[DateFilterRangeList.length - 1]
    );

    const [dateRangeFilterAnchor, setDateRangeFilterAnchor] =
        React.useState(null);
    const openedDateRangeFilter = Boolean(dateRangeFilterAnchor);
    const handleOpenDateRangeFilter = useCallback((event) => {
        setDateRangeFilterAnchor(event.currentTarget);
    }, []);
    const handleCloseDateRangeFilter = useCallback(() => {
        setDateRangeFilterAnchor(null);
    }, []);

    const changeCalenderFilter = useCallback(
        (filter) => () => {
            // console.warn("filter", filter);
            setCalenderFilter(filter);
            handleCloseDateRangeFilter?.();
        },
        [handleCloseDateRangeFilter]
    );

    const [calenderOpen, setCalenderOpen] = useState(false);
    const [calenderValue, setCalenderValue] = useState(null);

    const [confirmedCalenderValue, setConfirmedCalenderValue] = useState(null);

    const calenderFilterShowValue = useMemo(() => {
        if (calenderFilter) {
            const values = calenderFilter?.getValue();
            // console.warn("values", values);
            const startDate = values?.[0];
            const endDate = values?.[1];
            if (startDate.isSame(endDate, "date")) {
                return startDate.format("LL");
            } else {
                return startDate?.format("LL") + " to " + endDate?.format("LL");
            }
        }
        return null;
    }, [calenderFilter]);

    useEffect(() => {
        if (calenderFilter) {
            // console.warn(
            //   "calenderFilter----------",
            //   calenderFilter,
            //   calenderFilter.getValue()
            // );
            setConfirmedCalenderValue(calenderFilter.getValue());
        }
    }, [calenderFilter]);

    useEffect(() => {
        setCalenderValue(confirmedCalenderValue);
    }, [confirmedCalenderValue]);

    const openCalender = useCallback(() => {
        const nodes = document.querySelectorAll(`#${containerId} input`);
        if (nodes?.[0]) {
            nodes?.[0]?.focus?.();
        }
        setCalenderOpen(true);
    }, [containerId]);

    const closeCalender = useCallback(() => {
        setCalenderOpen(false);
        //set default confirm value
        setCalenderValue(confirmedCalenderValue);
    }, [confirmedCalenderValue]);

    const resetCalender = useCallback(() => {
        setCalenderOpen(false);
        //unset calender
        // setCalenderFilter(DateFilterRangeList[0]);
        setCalenderFilter(DateFilterRangeList[DateFilterRangeList.length - 1]);
    }, []);

    const confirmCalender = useCallback(() => {
        setCalenderOpen(false);
        setConfirmedCalenderValue(calenderValue);
        setCalenderFilter(null);
    }, [calenderValue]);

    const toggleCalender = useCallback(() => {
        if (calenderOpen) {
            closeCalender();
        } else {
            openCalender();
        }
    }, [calenderOpen, openCalender, closeCalender]);

    //   const confirmCalenderTwo = useCallback(
    //     (calvalues) => {
    //       setConfirmedCalenderValue(calvalues);
    //     },
    //     [calvalues]
    //   );

    const confirmCalenderTwo = (calvalues) => {
        // console.warn("calvaluesOne", calvalues);
        setCalenderValue(calvalues);
        setConfirmedCalenderValue(calvalues);
        setCalenderFilter(null);
    };

    return {
        calenderOpen,
        openCalender,
        closeCalender,
        toggleCalender,
        confirmCalender,
        confirmCalenderTwo,
        DateFilterRangeList,
        changeCalenderFilter,
        resetCalender,
        calenderFilterShowValue,
        calenderFilter,
        confirmedCalenderValue,
        setCalenderValue,
        calenderValue,
        setConfirmedCalenderValue,
        setCalenderFilter,
        dateRangeFilter: {
            openedDateRangeFilter,
            handleCloseDateRangeFilter,
            handleOpenDateRangeFilter,
            dateRangeFilterAnchor,
        },
    };
}
