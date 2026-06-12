<table>
    <thead>
        <tr>
            <th align="center" colspan="9">
                <b>{{ trans('page.permission') }}</b>
            </th>
        </tr>
        @if ($role)
            <tr>
                <th align="center" colspan="9">
                    {{ trans('page.role') }} : {{ $role->name }}
                </th>
            </tr>
        @endif
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <th align="center" colspan="9">
                {{ trans('field.printed_at') }} : {{ now()->isoFormat('LLLL') }}
            </th>
        </tr>
        <tr>
            <td colspan="9"></td>
        </tr>
        <tr>
            <th align="center"><b>{{ trans('field.#') }}</b></th>
            <th align="center"><b>{{ trans('field.id') }}</b></th>
            <th align="center"><b>{{ trans('field.name') }}</b></th>
            <th align="center"><b>{{ trans('field.guard_name') }}</b></th>
            <th align="center"><b>{{ trans('field.roles') }}</b></th>
            <th align="center"><b>{{ trans('index.total') }} {{ trans('page.permission') }}</b></th>
            <th align="center"><b>{{ trans('index.total') }} {{ trans('page.user') }}</b></th>
            <th align="center"><b>{{ trans('field.created_at') }}</b></th>
            <th align="center"><b>{{ trans('field.updated_at') }}</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($permissions as $permission)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{ $permission->id }}</td>
                <td align="left">{{ $permission->name }}</td>
                <td align="center">{{ $permission->guard_name }}</td>
                <td align="left">{{ $permission->roles->pluck('name')->join(', ') }}</td>
                <td align="center">{{ $permission->roles_count }}</td>
                <td align="center">{{ $permission->users_count }}</td>
                <td align="left">{{ $permission->created_at }}</td>
                <td align="left">{{ $permission->updated_at }}</td>
            </tr>
        @empty
            <tr>
                <td align="center" colspan="9">
                    {{ trans('message.no_data_available') }}
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="9"></td>
        </tr>
    </tfoot>
</table>
