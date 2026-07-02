<table>
    <thead>
        <tr>
            <th align="center" colspan="20">
                <b>{{ trans('page.property') }}</b>
            </th>
        </tr>
        <tr>
            <td colspan="20"></td>
        </tr>
        <tr>
            <th align="center" colspan="20">
                {{ trans('field.printed_at') }} : {{ now()->isoFormat('LLLL') }}
            </th>
        </tr>
        <tr>
            <td colspan="20"></td>
        </tr>
        <tr>
            <th align="center"><b>{{ trans('field.#') }}</b></th>
            <th align="center"><b>{{ trans('field.id') }}</b></th>
            <th align="center"><b>{{ trans('field.code') }}</b></th>
            <th align="center"><b>{{ trans('field.name') }}</b></th>
            <th align="center"><b>{{ trans('field.district_id') }}</b></th>
            <th align="center"><b>{{ trans('field.area_id') }}</b></th>
            <th align="center"><b>{{ trans('field.image') }}</b></th>
            <th align="center"><b>{{ trans('field.monthly_price') }}</b></th>
            <th align="center"><b>{{ trans('field.yearly_price') }}</b></th>
            <th align="center"><b>{{ trans('field.description') }}</b></th>
            <th align="center"><b>{{ trans('field.fully_furnished') }}</b></th>
            <th align="center"><b>{{ trans('field.pool') }}</b></th>
            <th align="center"><b>{{ trans('field.bedroom') }}</b></th>
            <th align="center"><b>{{ trans('field.land_size') }}</b></th>
            <th align="center"><b>{{ trans('field.building_size') }}</b></th>
            <th align="center"><b>{{ trans('field.rental_type') }}</b></th>
            <th align="center"><b>{{ trans('field.created_at') }}</b></th>
            <th align="center"><b>{{ trans('field.updated_at') }}</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($properties as $property)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{ $property->id }}</td>
                <td align="center">{{ $property->code }}</td>
                <td align="left">{{ $property->name }}</td>
                <td align="left">{{ $property->district?->name }}</td>
                <td align="left">{{ $property->area?->name }}</td>
                <td height="50" width="20"></td>
                <td align="right">{{ $property->monthly_price }}</td>
                <td align="right">{{ $property->yearly_price }}</td>
                <td align="left">
                    {{ Str::of($property->description)->replace(['<br>', '<br/>', '<br />'], PHP_EOL)->stripTags()->toString() }}
                </td>
                <td align="center">{{ Str::yesNo($property->fully_furnished) }}</td>
                <td align="center">{{ Str::yesNo($property->pool_size) }}</td>
                <td align="center">{{ $property->bedroom?->value }}</td>
                <td align="center">{{ $property->land_size }}</td>
                <td align="center">{{ $property->building_size }}</td>
                <td align="center">{{ $property->rental_type?->name }}</td>
                <td align="left">{{ $property->created_at }}</td>
                <td align="left">{{ $property->updated_at }}</td>
            </tr>
        @empty
            <tr>
                <td align="center" colspan="20">
                    {{ trans('message.no_data_available') }}
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="20"></td>
        </tr>
    </tfoot>
</table>
