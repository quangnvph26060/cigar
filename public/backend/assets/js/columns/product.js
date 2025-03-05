const columns = [
    {
        className: "dt-control",
        orderable: false,
        data: null,
        defaultContent: "",
    },
    {
        data: "code",
        name: "code",
        title: "MÃ SẢN PHẨM",
        width: "12%",
    },
    {
        data: "name",
        name: "name",
        title: "TÊN SẢN PHẨM",
    },
    {
        data: "slug",
        name: "slug",
        title: "ĐƯỜNG DẪN",
    },
    {
        data: "price",
        name: "price",
        title: "Giá ($)",
        width: "8%",
    },
    {
        data: "variations_count",
        name: "variations_count",
        title: "BIẾN THỂ",
        width: "10%",
        searchable: false
    },
    {
        data: "status",
        name: "status",
        title: "TRẠNG THÁI",
        width: "12%",
        render(data, type, row) {
            return data == 1
                ? '<span class="badge bg-primary">Xuất bản</span>'
                : '<span class="badge bg-secondary">Chưa xuất bản</span>';
        },
    },
];
