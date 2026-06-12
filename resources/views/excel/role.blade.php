<table>
    <thead>
        <tr>
            <th align="center" colspan="8">
                <b>{{ trans('page.role') }}</b>
            </th>
        </tr>
        @if ($permission)
            <tr>
                <th align="center" colspan="8">
                    {{ trans('page.permission') }} : {{ $permission->name }}
                </th>
            </tr>
        @endif
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <th align="center" colspan="8">
                {{ trans('field.printed_at') }} : {{ now()->isoFormat('LLLL') }}
            </th>
        </tr>
        <tr>
            <td colspan="8"></td>
        </tr>
        <tr>
            <th align="center"><b>{{ trans('field.#') }}</b></th>
            <th align="center"><b>{{ trans('field.id') }}</b></th>
            <th align="center"><b>{{ trans('field.name') }}</b></th>
            <th align="center"><b>{{ trans('field.guard_name') }}</b></th>
            <th align="center"><b>{{ trans('index.total') }} {{ trans('page.permission') }}</b></th>
            <th align="center"><b>{{ trans('index.total') }} {{ trans('page.user') }}</b></th>
            <th align="center"><b>{{ trans('field.created_at') }}</b></th>
            <th align="center"><b>{{ trans('field.updated_at') }}</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($roles as $role)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{ $role->id }}</td>
                <td align="left">{{ $role->name }}</td>
                <td align="center">{{ $role->guard_name }}</td>
                <td align="center">{{ $role->permissions_count }}</td>
                <td align="center">{{ $role->users_count }}</td>
                <td align="left">{{ $role->created_at }}</td>
                <td align="left">{{ $role->updated_at }}</td>
            </tr>
        @empty
            <tr>
                <td align="center" colspan="8">
                    {{ trans('message.no_data_available') }}
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="8"></td>
        </tr>
    </tfoot>
</table>
