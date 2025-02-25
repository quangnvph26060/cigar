let thead = "<thead><tr>";
thead += '<th><input type="checkbox" id="selectAll" /></th>';
columns.forEach(function (column) {
    thead += "<th>" + column.title + "</th>";
});
thead += "</tr></thead>";

// Thêm <thead> vào bảng
$("#myTable").append(thead);

const dataTables = (api, columns, model) => {
    const table = $("#myTable").DataTable({
        // Định nghĩa biến table
        processing: true,
        serverSide: true,
        ajax: api,
        columns: [
            {
                data: "checkbox",
                name: "checkbox",
                orderable: false,
                searchable: false,
                width: "5px",
                className: "text-center",
            },
            ...columns,
        ],
        createdRow: function (row, data) {
            $(row).attr("data-id", data.id);
        },
        order: [],
    });

    $('label[for="dt-length-0"]').remove();

    const targetDiv = $(".dt-layout-cell.dt-layout-start .dt-length");

    let _html = `
    <div id="actionDiv" style="display: none;">
        <div class="d-flex">
            <select id="actionSelect" class="form-select rounded-start" style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important">
                <option value="">-- Chọn hành động --</option>
                <option value="delete">Xóa</option>
            </select>
            <button id="applyAction" class="btn btn-outline-danger btn-sm rounded-end" style="border-bottom-left-radius: 0 !important; border-top-left-radius: 0 !important;">Apply</button>
        </div>
    </div>
    `;

    targetDiv.after(_html);

    $("#myTable tbody").on("click", 'input[type="checkbox"]', function () {
        const allChecked =
            $('#myTable tbody input[type="checkbox"]').length ===
            $('#myTable tbody input[type="checkbox"]:checked').length;
        $('#myTable thead input[type="checkbox"]').prop("checked", allChecked);
        toggleActionDiv();
    });

    $("#applyAction").on("click", function () {
        const selectedAction = $("#actionSelect").val();

        if (!selectedAction) return;

        const selectedIds = $(".row-checkbox:checked")
            .map(function () {
                return $(this).val();
            })
            .get();

        if (selectedAction === "delete") {
            $.ajax({
                url: "/admin/delete-items",
                method: "POST",
                data: {
                    ids: selectedIds,
                    model: model,
                },
                success: function (response) {
                    table.ajax.reload(); // Sử dụng biến table thay vì gọi lại $('#myTable').DataTable()
                    Toast.fire({
                        icon: "success",
                        title: response.message
                    });
                    $('#actionSelect').val('');
                    $('input[type="checkbox"]').prop("checked", false);
                    toggleActionDiv();
                },
                error: function () {
                    alert("Có lỗi xảy ra, vui lòng thử lại!");
                },
            });
        }
    });
};

function toggleActionDiv() {

    if ($(".row-checkbox:checked").length > 0) {
        $("#actionDiv").show();
    } else {
        $("#actionDiv").hide();
    }
}

$('#myTable thead input[type="checkbox"]').on("click", function () {
    const isChecked = $(this).prop("checked");
    $('#myTable tbody input[type="checkbox"]').prop("checked", isChecked);
    toggleActionDiv();
});

const handleDestroy = (model) => {
    $("tbody").on("click", ".btn-destroy", function (e) {
        e.preventDefault();

        if (confirm("Chắc chắn muốn xóa?")) {
            var form = $(this).closest("form");

            form.append("model", model);

            $.ajax({
                url: form.attr("action"),
                method: "POST",
                data: form.serialize(),
                success: function (response) {
                    $("#myTable").DataTable().ajax.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR);
                },
            });
        }
    });
};
