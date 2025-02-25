const columns = [
    {
        data: "name",
        name: "name",
        title: "TÊN THUỘC TÍNH",
        render(data, type, row) {
            return `<a href="attributes-values/${row.id}"><strong>${data}</strong></a>
            <a href="javascript:void(0)" data-id="${row.id}" data-slug="${row.slug}" data-name="${data}" class="d-block fw-bold" style="cursor: pointer;">sửa</a>`;
        },
    },
    {
        data: "slug",
        name: "slug",
        title: "ĐƯỜNG DẪN",
    },
    {
        data: "attribute_value",
        name: "attribute_value",
        title: "GIÁ TRỊ",
        orderable: false,
        searchable: false,
    },
];
