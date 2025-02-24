const columns = [
    {
        data: "name",
        title: "TÊN DANH MỤC",
        render(data, type, row) {
            return `<a href="/admin/categories/${row.id}/edit"><strong>${data}</strong></a>`
        },
    },
    {
        data: "slug",
        title: "ĐƯỜNG DẪN THÂN THIỆN",
    },
    {
        data: "attribute_name",
        name: "attribute_name",
        title: "THUỘC TÍNH",
        orderable: false,
        searchable: false,
    },
    {
        data: "product_count",
        name: "product_count",
        title: "SỐ LƯỢNG SẢN PHẨM",
    },
];
