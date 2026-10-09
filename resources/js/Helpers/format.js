const currencyFormatter = new Intl.NumberFormat('en-QA', {
    style: 'currency',
    currency: 'QAR',
    maximumFractionDigits: 0,
});

const numberFormatter = new Intl.NumberFormat('en-US');

export const formatPrice = (value) => currencyFormatter.format(Number(value ?? 0));

export const formatNumber = (value) => numberFormatter.format(Number(value ?? 0));

/**
 * Whole days left until the given ISO date (0 when it is today or in the past).
 */
export const daysUntil = (isoDate) => {
    const end = new Date(`${isoDate}T23:59:59`);
    return Math.max(0, Math.ceil((end - Date.now()) / 86_400_000));
};

/**
 * Standard amortised monthly instalment.
 */
export const monthlyInstalment = (principal, annualRatePercent, months) => {
    if (principal <= 0 || months <= 0) {
        return 0;
    }

    const monthlyRate = annualRatePercent / 100 / 12;

    if (monthlyRate === 0) {
        return principal / months;
    }

    return (principal * monthlyRate) / (1 - (1 + monthlyRate) ** -months);
};
