const columns = [
    {
        data: "type",
        name: "type",
        title: "KIỂU SLIDER",
        render: function(data, type, row){
            return `<a class="fw-bold" href="/admin/sliders/${row.id}/edit">${data == "big" ? 'Slider Lớn' : 'Slider Nhỏ'}</a>`
        }
    },
    {
        data: "count_items",
        name: "count_items",
        title: "SỐ LƯỢNG ẢNH",
    },
];
