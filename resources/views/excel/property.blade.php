<table>
    <thead>
        <tr>
            <th align="center" colspan="16">
                <b>{{ trans('page.property') }}</b>
            </th>
        </tr>
        <tr>
            <td colspan="16"></td>
        </tr>
        <tr>
            <th align="center" colspan="16">
                {{ trans('field.printed_at') }} : {{ now()->isoFormat('LLLL') }}
            </th>
        </tr>
        <tr>
            <td colspan="16"></td>
        </tr>
        <tr>
            <th valign="middle" align="center">
                <b>{{ trans('field.#') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.code') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.name') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.user') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.availability_date') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.visit_date') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.bedroom') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.latitude') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.longitude') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.address') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.district_id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.area_id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.monthly_price') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.yearly_price') }}</b>
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
        @forelse ($properties as $property)
            <tr>
                <td valign="middle" align="center">
                    {{ $loop->iteration }}
                </td>
                <td valign="middle" align="center">
                    {{ $property->id }}
                </td>
                <td valign="middle" align="center">
                    {{ $property->code }}
                </td>
                <td valign="middle">
                    {{ $property->name }}
                </td>
                <td valign="middle">
                    {{ $property->user?->name }}
                </td>
                <td valign="middle">
                    {{ $property->availability_date?->toDateString() }}
                </td>
                <td valign="middle">
                    {{ $property->visit_date?->toDateString() }}
                </td>
                <td valign="middle" align="center">
                    {{ $property->bedroom->name }}
                </td>
                <td valign="middle">
                    {{ $property->latitude }}
                </td>
                <td valign="middle">
                    {{ $property->longitude }}
                </td>
                <td valign="middle">
                    {{ $property->address }}
                </td>
                <td valign="middle">
                    {{ $property->district?->name }}
                </td>
                <td valign="middle">
                    {{ $property->area?->name }}
                </td>
                <td valign="middle" align="right">
                    {{ $property->monthly_price }}
                </td>
                <td valign="middle" align="right">
                    {{ $property->yearly_price }}
                </td>
                <td valign="middle">
                    {{ $property->created_at }}
                </td>
                <td valign="middle">
                    {{ $property->updated_at }}
                </td>
            </tr>
        @empty
            <tr>
                <td align="center" colspan="16">
                    {{ trans('message.no_data_available') }}
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="16"></td>
        </tr>
    </tfoot>
</table>
