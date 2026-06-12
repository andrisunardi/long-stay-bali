<table>
    <thead>
        <tr>
            <th align="center" colspan="14">
                <b>{{ trans('page.oauth') }}</b>
            </th>
        </tr>
        <tr>
            <td colspan="14"></td>
        </tr>
        <tr>
            <th align="center" colspan="14">
                {{ trans('field.printed_at') }} : {{ now()->isoFormat('LLLL') }}
            </th>
        </tr>
        <tr>
            <td colspan="14"></td>
        </tr>
        <tr>
            <th align="center"><b>{{ trans('field.#') }}</b></th>
            <th align="center"><b>{{ trans('field.id') }}</b></th>
            <th align="center"><b>{{ trans('field.code') }}</b></th>
            <th align="center"><b>{{ trans('field.name') }}</b></th>
            <th align="center"><b>{{ trans('field.refresh_token') }}</b></th>
            <th align="center"><b>{{ trans('field.access_token') }}</b></th>
            <th align="center"><b>{{ trans('field.token_type') }}</b></th>
            <th align="center"><b>{{ trans('field.expires_in') }}</b></th>
            <th align="center"><b>{{ trans('field.scope') }}</b></th>
            <th align="center"><b>{{ trans('field.created') }}</b></th>
            <th align="center"><b>{{ trans('field.created_by') }}</b></th>
            <th align="center"><b>{{ trans('field.updated_by') }}</b></th>
            <th align="center"><b>{{ trans('field.created_at') }}</b></th>
            <th align="center"><b>{{ trans('field.updated_at') }}</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($oauths as $oauth)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{ $oauth->id }}</td>
                <td align="left">{{ $oauth->code }}</td>
                <td align="left">{{ $oauth->name }}</td>
                <td align="left">{{ $oauth->refresh_token }}</td>
                <td align="left">{{ $oauth->access_token }}</td>
                <td align="left">{{ $oauth->token_type }}</td>
                <td align="left">{{ $oauth->expires_in }}</td>
                <td align="left">{{ $oauth->scope }}</td>
                <td align="left">{{ $oauth->created }}</td>
                <td align="left">{{ $oauth->createdBy?->name }}</td>
                <td align="left">{{ $oauth->updatedBy?->name }}</td>
                <td align="left">{{ $oauth->created_at }}</td>
                <td align="left">{{ $oauth->updated_at }}</td>
            </tr>
        @empty
            <tr>
                <td align="center" colspan="14">
                    {{ trans('message.no_data_available') }}
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="14"></td>
        </tr>
    </tfoot>
</table>
