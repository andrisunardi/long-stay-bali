<table>
    <thead>
        <tr>
            <th align="center" colspan="13">
                <b>{{ trans('page.area') }}</b>
            </th>
        </tr>
        <tr>
            <td colspan="13"></td>
        </tr>
        <tr>
            <th align="center" colspan="13">
                {{ trans('field.printed_at') }} : {{ now()->isoFormat('LLLL') }}
            </th>
        </tr>
        <tr>
            <td colspan="13"></td>
        </tr>
        <tr>
            <th align="center"><b>{{ trans('field.#') }}</b></th>
            <th align="center"><b>{{ trans('field.id') }}</b></th>
            <th align="center"><b>{{ trans('field.district_id') }}</b></th>
            <th align="center"><b>{{ trans('field.name') }}</b></th>
            <th align="center"><b>{{ trans('field.promoted') }}</b></th>
            <th align="center"><b>{{ trans('field.show') }}</b></th>
            <th align="center"><b>{{ trans('field.active') }}</b></th>
            <th align="center"><b>{{ trans('index.total') }} {{ trans('page.contact') }}</b></th>
            <th align="center"><b>{{ trans('index.total') }} {{ trans('page.property') }}</b></th>
            <th align="center"><b>{{ trans('field.created_by') }}</b></th>
            <th align="center"><b>{{ trans('field.updated_by') }}</b></th>
            <th align="center"><b>{{ trans('field.created_at') }}</b></th>
            <th align="center"><b>{{ trans('field.updated_at') }}</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($areas as $area)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{ $area->id }}</td>
                <td align="left">{{ $area->district?->name }}</td>
                <td align="left">{{ $area->name }}</td>
                <td align="center">{{ Str::yesNo($area->is_promoted) }}</td>
                <td align="center">{{ Str::yesNo($area->is_show) }}</td>
                <td align="center">{{ Str::yesNo($area->is_active) }}</td>
                <td align="center">{{ $area->contacts_count }}</td>
                <td align="center">{{ $area->properties_count }}</td>
                <td align="left">{{ $area->createdBy?->name }}</td>
                <td align="left">{{ $area->updatedBy?->name }}</td>
                <td align="left">{{ $area->created_at }}</td>
                <td align="left">{{ $area->updated_at }}</td>
            </tr>
        @empty
            <tr>
                <td align="center" colspan="13">
                    {{ trans('message.no_data_available') }}
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="13"></td>
        </tr>
    </tfoot>
</table>
