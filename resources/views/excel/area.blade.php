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
            <th valign="middle" align="center">
                <b>{{ trans('field.#') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.district_id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.name') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.promoted') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.show') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.active') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('index.total') }} {{ trans('page.contact') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('index.total') }} {{ trans('page.property') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.created_by') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.updated_by') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.created_at') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.updated_at') }}</b>
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($areas as $area)
            <tr>
                <td valign="middle" align="center">
                    {{ $loop->iteration }}
                </td>
                <td valign="middle" align="center">
                    {{ $area->id }}
                </td>
                <td valign="middle" align="left">
                    {{ $area->district?->name }}
                </td>
                <td valign="middle" align="left">
                    {{ $area->name }}
                </td>
                <td valign="middle" align="center">
                    {{ Str::yesNo($area->is_promoted) }}
                </td>
                <td valign="middle" align="center">
                    {{ Str::yesNo($area->is_show) }}
                </td>
                <td valign="middle" align="center">
                    {{ Str::yesNo($area->is_active) }}
                </td>
                <td valign="middle" align="center">
                    {{ $area->contacts_count }}
                </td>
                <td valign="middle" align="center">
                    {{ $area->properties_count }}
                </td>
                <td valign="middle" align="left">
                    {{ $area->createdBy?->name }}
                </td>
                <td valign="middle" align="left">
                    {{ $area->updatedBy?->name }}
                </td>
                <td valign="middle" align="left">
                    {{ $area->created_at }}
                </td>
                <td valign="middle" align="left">
                    {{ $area->updated_at }}
                </td>
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
