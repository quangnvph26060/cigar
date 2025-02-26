const columns = [
    {
        data: "name",
        name: "name",
        title: "TÊN DANH MỤC",
        render(data, type, row) {
            return `<a href="/admin/categories/${row.id}/edit"><strong>${data}</strong></a>`
        },
    },
    {
        data: "slug",
        name: "slug",
        title: "ĐƯỜNG DẪN",
    },
    {
        data: "attribute_name",
        name: "attribute_name",
        title: "THUỘC TÍNH",
        orderable: false,
        searchable: false,
        width: "30%"
    },
    {
        data: "parent_id",
        name: "parent_id",
        title: "DANH MỤC CHA",
        orderable: false,
        searchable: false,
    },
    {
        data: "product_count",
        name: "product_count",
        title: "SỐ LƯỢNG SẢN PHẨM",
    },
];
