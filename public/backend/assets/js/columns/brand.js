const columns = [
    {
        className: "dt-control",
        orderable: false,
        data: null,
        defaultContent: "",
    },
    {
        data: "name",
        name: "name",
        title: "TÊN THƯƠNG HIỆU",
        render: function (data, type, row) {
            return `<a href='/admin/brands/${row.id}/edit'><strong>${data}</strong></a>`;
        },
    },
    {
        data: "slug",
        name: "slug",
        title: "ĐƯỜNG DẪN",
    },
    {
        data: "position",
        name: "position",
        title: "VỊ TRÍ",
        className: "position",
    },
    {
        data: "status",
        name: "status",
        title: "TRẠNG THÁI",
        render: function (data, type, row) {
            return data == 1
                ? '<span class="badge bg-success">Xuất bản</span>'
                : '<span class="badge bg-warning">Chưa xuất bản</span>';
        },
    },
];
