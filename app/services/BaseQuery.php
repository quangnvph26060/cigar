<?php

namespace App\Services;

class BaseQuery
{
    protected $modelClass;

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    public function buildQuery(array $columns, array $relations = [], $withCount = [], $request = null, string $sortRelationColumn = null, $where = [])
    {
        $query = $this->modelClass::query()->select($columns);

        if (count($relations) > 0) {
            $query->with($relations);
        }

        if ($withCount) {
            $query->withCount($withCount);
        }

        foreach ($where as $condition) {
            if (count($condition) === 3) {
                $query->where($condition[0], $condition[1], $condition[2]);
            } elseif (count($condition) === 2) {
                $query->where($condition[0], $condition[1]);
            }
        }

        $query->when(empty($request->order), fn($q) => $q->latest('id'))
            ->when(!empty($request->order) && $request->order[0]['name'] == $sortRelationColumn, function ($q) use ($request) {
                return $q->orderBy($request->order[0]['name'], $request->order[0]['dir']);
            });

        logInfo($query->toSql());

        return $query;
    }

    public function processDataTable($query, callable $customColumns, array $rawColumn = [])
    {
        $dataTable = DataTables()->eloquent($query);

        // Gọi callback để xử lý phần tùy chỉnh
        $dataTable = $customColumns($dataTable);

        $rawColumn[] = 'checkbox';

        // Kiểm tra nếu có cột cần xử lý raw
        if (!empty($rawColumn)) {
            // Đảm bảo rằng rawColumn là một mảng hợp lệ, không chứa các giá trị trống
            $validRawColumns = array_filter($rawColumn, fn($column) => !empty($column));
            $dataTable->rawColumns($validRawColumns);
        }

        return $dataTable
            ->addColumn('checkbox', fn($row) => "<input type='checkbox' class='row-checkbox form-check-input' value='{$row->id}'>")
            ->make(true);
    }
}
