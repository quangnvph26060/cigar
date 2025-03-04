const columns = [
    {
        data: "name",
        name: "name",
        title: "TÊN",
        render: function (data, type, row) {
            return `<a href='/admin/sliders/${row.id}/edit'><strong>${data}</strong></a>`;
        },
    },
    {
        data: "images",
        name: "images",
        title: "Ảnh",
        orderable: false,
        searchable: false,
    },
    {
        data: "position",
        name: "position",
        title: "VỊ TRÍ",
        className: "position",
    },
    {
        data: "created_at",
        name: "created_at",
        title: "NGÀY TẠO",
    },
];
