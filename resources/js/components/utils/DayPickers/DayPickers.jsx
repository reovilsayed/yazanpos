import React, { useEffect, useRef, useState } from "react";
import { DatePicker, Space } from "antd";
import { CalendarOutlined } from "@ant-design/icons";
import moment from "moment";
import { format } from "date-fns";
const { RangePicker } = DatePicker;
import "./DayPickers.css";
import { Button } from "bootstrap";
import { Link } from "react-router-dom";
import Modal from "react-responsive-modal";
import { BiXCircle } from "react-icons/bi";
export const NotificationFilterDates = [
    {
        name: "Today",
        value: "today",
    },
    {
        name: "Yesterday",
        value: "yesterday",
    },
    {
        name: "This week",
        value: "this_week",
    },
    {
        name: "Last 7 days",
        value: "last_7_days",
    },
    {
        name: "This month",
        value: "this_month",
    },
    {
        name: "Last month",
        value: "last_month",
    },
    {
        name: "Last 6 months",
        value: "last_6_months",
    },
    {
        name: "This year",
        value: "this_year",
    },
    {
        name: "Last year",
        value: "last_year",
    },
];

export const DayPickers = ({
    setFrom,
    setTo,
    from,
    to,
    start,
    end,
    date,
    setDate,
    filterDate1,
    setFilterDate1,
    filterDate2,
    setFilterDate2,
}) => {
    const [open, setOpen] = useState(false);
    const handelRefFun = useRef();

    const [openModal, setOpenModal] = useState(false);

    useEffect(() => {
        const clickOutside = (e) => {
            if (
                handelRefFun.current &&
                !handelRefFun.current.contains(e.target)
            ) {
                setOpenModal(false);
            }
        };

        document.addEventListener("mousedown", clickOutside);
        document.addEventListener("touchstart", clickOutside);

        return () => {
            document.removeEventListener("mousedown", clickOutside);
            document.removeEventListener("touchstart", clickOutside);
        };
    }, [handelRefFun, setOpenModal]);

    //    dates

    const [search, setSearch] = useState("");
    const getDataFromChild = (data) => {
        if (!(typeof data === typeof ".")) {
            if ("startDate" in data && "endDate" in data) {
                setDate(data);
            }
        } else {
            setSearch(data);
        }
    };
    const [currentDateFilter, setCurrentDateFilter] = useState("today");
    const [startDate, setStartDate] = useState({
        day: "",
        month: "",
        year: "",
    });
    const [startDate2, setStartDate2] = useState({
        day: "",
        month: "",
        year: "",
    });

    const [day, setDay] = useState(0);
    const [month, setMonth] = useState(0);
    const [year, setYear] = useState(0);

    const [day2, setDay2] = useState(0);
    const [month2, setMonth2] = useState(0);
    const [year2, setYear2] = useState(0);

    const handleChildData = (anchorEl) => {
        if (anchorEl.day) {
            setStartDate({ ...startDate, day: anchorEl.day });
        } else if (anchorEl.month) {
            setStartDate({ ...startDate, month: anchorEl.month });
        } else if (anchorEl.year) {
            setStartDate({ ...startDate, year: anchorEl.year });
        }
    };

    const handleChildData2 = (anchorEl) => {
        if (anchorEl.day) {
            setStartDate2({ ...startDate2, day: anchorEl.day });
        } else if (anchorEl.month) {
            setStartDate2({ ...startDate2, month: anchorEl.month });
        } else if (anchorEl.year) {
            setStartDate2({ ...startDate2, year: anchorEl.year });
        }
    };

    const filtereditorList2 = (type, day) => {
        const date = new Date();
        let dd = date.getDate();
        let mm = date.getMonth();
        let yy = date.getFullYear();
        let getThisWeek = new Date();
        function getMonday(d) {
            var day = d.getDay();
            var diff = d.getDate() - day + (day === 0 ? -6 : 1); // adjust when day is sunday
            getThisWeek = new Date(d.setDate(diff));
        }

        if (day == "today") {
            let currentDate = Number(dd) > 9 ? Number(dd) : "0" + Number(dd);
            let currentMonth =
                Number(mm) > 9 ? Number(mm) + 1 : "0" + (Number(mm) + 1);
            let currentYear = Number(yy);
            let published_at_from =
                currentYear + "-" + currentMonth + "-" + currentDate;
            let published_at_to =
                currentYear + "-" + currentMonth + "-" + currentDate;
            getDataFromChild({
                startDate: published_at_from,
                endDate: published_at_to,
                type: "Today",
            });
        } else if (day == "yesterday") {
            let datex = date;
            datex.setDate(dd - 1);
            let currentDate =
                datex.getDate() > 9 ? datex.getDate() : "0" + datex.getDate();
            let currentMonth =
                datex.getMonth() > 9
                    ? datex.getMonth() + 1
                    : "0" + (datex.getMonth() + 1);
            let currentYear = datex.getFullYear();
            let published_at_from =
                currentYear + "-" + currentMonth + "-" + currentDate;
            let published_at_to =
                currentYear + "-" + currentMonth + "-" + currentDate;
            getDataFromChild({
                startDate: published_at_from,
                endDate: published_at_to,
                type: "Yesterday",
            });
        } else if (day == "this_week") {
            getMonday(date);
            let currentDate = Number(dd) > 9 ? Number(dd) : "0" + Number(dd);
            let currentMonth = mm > 9 ? mm + 1 : "0" + (mm + 1);
            let currentYear = Number(yy);
            let currentDate2 =
                currentDate + 7 <= 30 ? currentDate + 7 : currentDate + 7 - 30;
            let currentMonth2 =
                currentDate < currentDate2
                    ? mm > 9
                        ? mm + 1
                        : "0" + (mm + 1)
                    : mm + 1 > 9
                    ? mm + 2
                    : "0" + (mm + 2);
            let currentYear2 = getThisWeek.getFullYear();
            let published_at_to =
                currentYear2 + "-" + currentMonth2 + "-" + currentDate2;
            let published_at_from =
                currentYear + "-" + currentMonth + "-" + currentDate;
            getDataFromChild({
                startDate: published_at_from,
                endDate: published_at_to,
                type: "This Week",
            });
        } else if (day == "last_7_days") {
            let currentDate = Number(dd) > 9 ? Number(dd) : "0" + Number(dd);
            let currentMonth =
                Number(mm) > 9 ? Number(mm) + 1 : "0" + (Number(mm) + 1);
            let currentYear = Number(yy);
            let datex = date;
            datex.setDate(date.getDate() - 7);
            let currentDate2 =
                datex.getDate() > 9 ? datex.getDate() : "0" + datex.getDate();
            let currentMonth2 =
                datex.getMonth() + 1 > 9
                    ? datex.getMonth() + 1
                    : "0" + (datex.getMonth() + 1);
            let currentYear2 = datex.getFullYear();
            let published_at_from =
                currentYear2 + "-" + currentMonth2 + "-" + currentDate2;
            let published_at_to =
                currentYear + "-" + currentMonth + "-" + currentDate;
            getDataFromChild({
                startDate: published_at_from,
                endDate: published_at_to,
                type: "Last 7 Days",
            });
        } else if (day == "this_month") {
            let currentDate = Number(dd) > 9 ? Number(dd) : "0" + Number(dd);
            let currentMonth =
                Number(mm) > 9 ? Number(mm) + 1 : "0" + (Number(mm) + 1);
            let currentYear = Number(yy);
            let currentDate2 = "0" + (Number(dd) - Number(dd) + 1);
            let currentMonth2 =
                Number(mm) > 9 ? Number(mm) + 1 : "0" + (Number(mm) + 1);
            let currentYear2 = Number(yy);
            let published_at_from =
                currentYear2 + "-" + currentMonth2 + "-" + currentDate2;
            let published_at_to =
                currentYear + "-" + currentMonth + "-" + currentDate;
            getDataFromChild({
                startDate: published_at_from,
                endDate: published_at_to,
                type: "This Month",
            });
        } else if (day == "last_month") {
            let datex = date;
            datex.setDate(date.getDate() - dd);
            let days = datex.getDate() + 1;
            let currentDate = datex.getDate();
            let currentMonth =
                datex.getMonth() + 1 > 9
                    ? datex.getMonth() + 1
                    : "0" + (datex.getMonth() + 1);
            let currentYear = datex.getFullYear();
            let currentDate2 = "0" + (datex.getDate() - datex.getDate() + 1);
            let currentMonth2 =
                datex.getMonth() + 1 > 9
                    ? datex.getMonth() + 1
                    : "0" + (datex.getMonth() + 1);
            let currentYear2 = datex.getFullYear();
            let published_at_from =
                currentYear2 + "-" + currentMonth2 + "-" + currentDate2;
            let published_at_to =
                currentYear + "-" + currentMonth + "-" + currentDate;
            getDataFromChild({
                startDate: published_at_from,
                endDate: published_at_to,
                type: "Last Month",
            });
        } else if (day == "last_6_months") {
            let datex = date;
            datex.setMonth(date.getMonth() - 5);
            let days = datex.getDate();
            let currentDate = dd > 9 ? dd : "0" + dd;
            let currentMonth = mm + 1 > 9 ? mm + 1 : "0" + (mm + 1);
            let currentYear = yy;
            let currentDate2 = "0" + (days - days + 1);
            let currentMonth2 =
                datex.getMonth() + 1 > 9
                    ? datex.getMonth() + 1
                    : "0" + (datex.getMonth() + 1);
            let currentYear2 = datex.getFullYear();
            let published_at_from =
                currentYear2 + "-" + currentMonth2 + "-" + currentDate2;
            let published_at_to =
                currentYear + "-" + currentMonth + "-" + currentDate;
            getDataFromChild({
                startDate: published_at_from,
                endDate: published_at_to,
                type: "Last 6 Months",
            });
        } else if (day == "this_year") {
            let currentDate = Number(dd) > 9 ? Number(dd) : "0" + Number(dd);
            let currentMonth =
                Number(mm) > 9 ? Number(mm) + 1 : "0" + (Number(mm) + 1);
            let currentYear = Number(yy);
            let currentDate2 = "0" + (Number(dd) - Number(dd) + 1);
            let currentMonth2 = "0" + (Number(mm) - Number(mm) + 1);
            let currentYear2 = Number(yy);
            let published_at_from =
                currentYear2 + "-" + currentMonth2 + "-" + currentDate2;
            let published_at_to =
                currentYear + "-" + currentMonth + "-" + currentDate;
            getDataFromChild({
                startDate: published_at_from,
                endDate: published_at_to,
                type: "This Year",
            });
        } else if (day == "last_year") {
            let datex = date;
            datex.setFullYear(yy - 1);
            let currentDate = 31;
            let currentMonth = datex.getMonth() * 0 + 12;
            let currentYear = datex.getFullYear();
            let currentDate2 = "0" + (datex.getDate() - datex.getDate() + 1);
            let currentMonth2 = "0" + (datex.getMonth() - datex.getMonth() + 1);
            let currentYear2 = datex.getFullYear();
            let published_at_from =
                currentYear2 + "-" + currentMonth2 + "-" + currentDate2;
            let published_at_to =
                currentYear + "-" + currentMonth + "-" + currentDate;
            getDataFromChild({
                startDate: published_at_from,
                endDate: published_at_to,
                type: "Last Year",
            });
        } else {
            getDataFromChild({ startDate: "", endDate: "", type: "" });
        }
        setCurrentDateFilter(day);
    };
    //    dates
    const [clear, setClear] = useState(false);
    const dayPickerRef = useRef(null);
    const handelChange = (date, dateString) => {
        setFrom(dateString[0]);
        setTo(dateString[1]);
        setFilterDate1(dateString[0]);
        setFilterDate2(dateString[1]);
    };
    const handelClick = () => {
        dayPickerRef.current.nativeElement.firstElementChild.click();
    };

    const handleReset = () => {
        setFrom(start);
        setTo(end);
        setFilterDate1("");
        setFilterDate2("");
        filtereditorList2("filter", "");
    };

    return (
        <div className="px-3 pb-4 relative">
            <div className="date-picker-container mt-3">
                <RangePicker
                    style={{
                        opacity: 0,
                        position: "absolute",
                        right: 0,
                        top: 0,
                    }}
                    className="date-picker-container"
                    ref={dayPickerRef}
                    id={{
                        start: "startInput",
                        end: "endInput",
                    }}
                    onChange={handelChange}
                    maxTagCount="responsive"
                    size="small"
                />
            </div>
            <div
                style={{
                    width: "100%",
                    marginTop: "3px",
                    display: "flex",
                    justifyContent: "space-between",
                    alignItems: "center",
                    padding: "10px 20px",
                    borderRadius: "10px",
                    border: "1px solid #eaeaea",
                }}
            >
                <div
                    style={{
                        display: "flex",
                        alignItems: "center",
                        width: "80%",
                    }}
                >
                    <p
                        className=""
                        style={{
                            display: "flex",
                            alignItems: "center",
                            gap: "2px",
                            fontSize: "12px",
                        }}
                    >
                        <span
                            className="responsive_font"
                            style={{
                                color: "#525050",
                                fontWeight: 500,
                                fontSize: "14px",
                            }}
                        >
                            Showing Date For
                        </span>{" "}
                        {/* render */}
                        <div className="position-relative">
                            <div
                                style={{
                                    position: "relative",
                                    color: "blue",
                                    cursor: "pointer",
                                    zIndex: 600,
                                }}
                                className="relative"
                                onClick={() => setOpenModal(!openModal)}
                            >
                                {date?.type ? (
                                    date.type
                                ) : (
                                    <span
                                        className="responsive_font"
                                        style={{
                                            fontWeight: 600,
                                        }}
                                    >
                                        All Time
                                    </span>
                                )}
                            </div>
                            {openModal && (
                                <div ref={handelRefFun}>
                                    {" "}
                                    <div
                                        style={{
                                            maxWidth: "130px",
                                            width: "130px",
                                            cursor: "pointer",
                                            position: "absolute",
                                            top: "170%",
                                            boxShadow: "1px 2px 2px 1px #8885",
                                            padding: "3px",
                                            zIndex: 200,
                                            borderRadius: "10px",
                                            background: "#FFFFFF",
                                        }}
                                    >
                                        {NotificationFilterDates?.map(
                                            (item) => (
                                                <div>
                                                    <div
                                                        onClick={() => {
                                                            filtereditorList2(
                                                                "filter",
                                                                item.value
                                                            );
                                                            setOpenModal(false);
                                                        }}
                                                        className="hover_Effect"
                                                    >
                                                        <span
                                                            style={{
                                                                fontSize:
                                                                    "14px",
                                                                color: "#525050",
                                                                padding:
                                                                    "3px 5px",

                                                                display:
                                                                    "block",
                                                                marginBottom:
                                                                    "1px",
                                                                borderRadius:
                                                                    "5px",
                                                            }}
                                                        >
                                                            {item.name}
                                                        </span>
                                                    </div>
                                                </div>
                                            )
                                        )}
                                    </div>
                                </div>
                            )}
                        </div>
                        {/* render */}
                        <span className="text-muted">
                            <span
                                className="responsive_font"
                                style={{
                                    color:
                                        date?.startDate?.length > 0 ||
                                        date?.endDate.length > 0
                                            ? "#111ae9"
                                            : filterDate1.length > 0 ||
                                              filterDate2?.length > 0
                                            ? "#111ae9"
                                            : "#ADADAD ",
                                    fontSize: "13px",
                                    fontWeight:
                                        date?.startDate?.length > 0 ||
                                        date?.endDate.length > 0
                                            ? 700
                                            : filterDate1.length > 0 ||
                                              filterDate2?.length > 0
                                            ? 700
                                            : 500,
                                }}
                            >
                                ({" "}
                                {moment(date?.startDate || from).format(
                                    "MMMM DD,YYYY"
                                )}{" "}
                                <span style={{ padding: "0 2px" }}>to</span>
                                {moment(date?.endDate || to).format(
                                    "MMMM DD,YYYY"
                                )}
                                )
                            </span>
                        </span>
                        <div>
                            {(date?.startDate?.length > 0 &&
                                date?.endDate?.length > 0) ||
                            (filterDate1?.length > 0 &&
                                filterDate2?.length > 0) ? (
                                <span
                                    onClick={handleReset}
                                    style={{
                                        marginLeft: "5px",
                                        display: "flex",
                                        alignItems: "center",
                                        borderRadius: "30px",
                                        cursor: "pointer",
                                    }}
                                >
                                    <BiXCircle style={{ marginRight: "3px" }} />
                                    <span>reset</span>
                                </span>
                            ) : (
                                ""
                            )}
                        </div>
                    </p>
                </div>
                <div
                    className="calender_hover"
                    style={{
                        cursor: "pointer",
                        border:
                            filterDate1?.length > 0 && filterDate2?.length > 0
                                ? "1px solid blue"
                                : "",
                        color: "inherit",
                    }}
                    onClick={handelClick}
                >
                    <svg
                        width="16"
                        height="17"
                        viewBox="0 0 16 17"
                        fill={
                            filterDate1?.length > 0 && filterDate2?.length > 0
                                ? "blue"
                                : "none"
                        }
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M10.975 0.250002C11.3232 0.249179 11.5986 0.521293 11.5994 0.884111L11.6002 1.50255C13.8595 1.68066 15.3519 3.22924 15.3543 5.60405L15.3633 12.5553C15.3665 15.1445 13.7493 16.7376 11.1572 16.7417L4.82555 16.75C2.24963 16.7533 0.612255 15.1223 0.609016 12.5256L0.600103 5.656C0.596869 3.26552 2.03666 1.72107 4.29595 1.51245L4.29514 0.894006C4.29433 0.531188 4.56156 0.25825 4.91787 0.25825C5.27417 0.257425 5.5414 0.529539 5.54221 0.892357L5.54302 1.46957L10.3531 1.46297L10.3523 0.88576C10.3515 0.522942 10.6187 0.250828 10.975 0.250002ZM11.3054 11.9583H11.2973C10.9248 11.9674 10.626 12.2816 10.6341 12.6609C10.6349 13.0402 10.9354 13.3527 11.3079 13.3609C11.6876 13.3601 11.9954 13.0459 11.9946 12.6584C11.9946 12.2708 11.686 11.9583 11.3054 11.9583ZM4.63282 11.9591C4.26032 11.9756 3.9688 12.2898 3.96961 12.6691C3.98662 13.0484 4.29433 13.3453 4.66683 13.328C5.03205 13.3115 5.32276 12.9973 5.30575 12.618C5.29765 12.2469 4.99723 11.9583 4.63282 11.9591ZM7.96913 11.955C7.59663 11.9723 7.30591 12.2857 7.30591 12.665C7.32292 13.0443 7.63064 13.3403 8.00314 13.3238C8.36754 13.3065 8.65906 12.9932 8.64205 12.613C8.63396 12.2428 8.33353 11.9542 7.96913 11.955ZM4.62877 8.99062C4.25627 9.00712 3.96556 9.32129 3.96637 9.70059C3.98257 10.0799 4.2911 10.3768 4.6636 10.3594C5.028 10.3429 5.31871 10.0288 5.3017 9.64947C5.29361 9.27841 4.99399 8.9898 4.62877 8.99062ZM7.96589 8.96176C7.59339 8.97826 7.30186 9.29243 7.30267 9.67173C7.31887 10.051 7.6274 10.3471 7.9999 10.3306C8.3643 10.3133 8.65501 9.99992 8.63881 9.62061C8.62991 9.24955 8.33029 8.96094 7.96589 8.96176ZM11.3022 8.96589C10.9297 8.97413 10.6382 9.27923 10.639 9.65854V9.66761C10.6471 10.0469 10.9548 10.3347 11.3281 10.3265C11.6925 10.3174 11.9832 10.0032 11.9751 9.62391C11.9581 9.26109 11.6658 8.96506 11.3022 8.96589ZM10.3547 2.73284L5.54464 2.73943L5.54545 3.40652C5.54545 3.76192 5.27903 4.04228 4.92273 4.04228C4.56642 4.0431 4.29838 3.76357 4.29838 3.40817L4.29757 2.77324C2.7185 2.93239 1.84474 3.86582 1.84717 5.65435L1.84798 5.91079L14.1081 5.8943V5.6057C14.0733 3.83283 13.189 2.9027 11.6018 2.76417L11.6026 3.3991C11.6026 3.75367 11.3281 4.03486 10.9799 4.03486C10.6236 4.03568 10.3556 3.75532 10.3556 3.40075L10.3547 2.73284Z"
                            fill="black"
                        ></path>
                    </svg>
                </div>
                {/* <CalendarOutlined >Click</CalendarOutlined> */}
            </div>
        </div>
    );
};
