export const truncate = (text, length = 100) => {
    if (text.length <= length) return text;
    return text.substring(0, length) + '...';
};

export const slugify = (text) => {
    return text
        .toString()
        .toLowerCase()
        .trim()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-');
};
