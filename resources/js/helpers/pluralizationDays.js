export default function pluralizationDays(countOfDays) {
    const cases = [2, 0, 1, 1, 1, 2];
    return countOfDays + ' ' + ['день', 'дня', 'дней'][countOfDays % 100 > 4 && countOfDays % 100 < 20 ? 2 : cases[Math.min(countOfDays % 10, 5)]];
}
