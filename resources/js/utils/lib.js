export const calculateDiscount = (price, discount = 0, percentage = false) => {
    if (!percentage) return price - discount;
    return price - (price * discount) / 100.0;
};
