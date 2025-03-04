const columns = [
    {
        data: "title",
        name: "title",
        title: "TIÊU ĐỀ BÀI VIẾT",
        render: function (data, type, row) {
            return `<a href='/admin/posts/${row.id}/edit'><strong>${data}</strong></a>`;
        },
    },
    {
        data: "slug",
        name: "slug",
        title: "ĐƯỜNG DẪN",
    },
    {
        data: "published_at",
        name: "published_at",
        title: "NGÀY ĐĂNG",
    },
    {
        data: "removed_at",
        name: "removed_at",
        title: "NGÀY NGỠ",
    },
    {
        data: "status",
        name: "status",
        title: "TRẠNG THÁI",
        render: function (data, type, row) {
            return data == 1
                ? '<span class="badge bg-primary">Xuất bản</span>'
                : '<span class="badge bg-secondary">Chưa xuất bản</span>';
        },
    },
];
