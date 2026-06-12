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
            <th align="center"><b>{{ trans('field.user') }}</b></th>
            <th align="center"><b>{{ trans('field.availability_date') }}</b></th>
            <th align="center"><b>{{ trans('field.visit_date') }}</b></th>
            <th align="center"><b>{{ trans('field.bedroom') }}</b></th>
            <th align="center"><b>{{ trans('field.villa_name') }}</b></th>
            <th align="center"><b>{{ trans('field.latitude') }}</b></th>
            <th align="center"><b>{{ trans('field.longitude') }}</b></th>
            <th align="center"><b>{{ trans('field.address') }}</b></th>
            <th align="center"><b>{{ trans('field.district_id') }}</b></th>
            <th align="center"><b>{{ trans('field.area_id') }}</b></th>
            <th align="center"><b>{{ trans('field.monthly_price') }}</b></th>
            <th align="center"><b>{{ trans('field.yearly_price') }}</b></th>
            <th align="center"><b>{{ trans('field.owner') }}</b></th>
            <th align="center"><b>{{ trans('field.owner_representative') }}</b></th>
            <th align="center"><b>{{ trans('field.counter') }}</b></th>
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
                <td align="left">{{ $property->user?->name }}</td>
                <td align="left">{{ $property->availability_date?->toDateString() }}</td>
                <td align="left">{{ $property->visit_date?->toDateString() }}</td>
                <td align="center">{{ $property->bedroom->name }}</td>
                <td align="left">{{ $property->villa_name }}</td>
                <td align="left">{{ $property->latitude }}</td>
                <td align="left">{{ $property->longitude }}</td>
                <td align="left">{{ $property->address }}</td>
                <td align="left">{{ $property->district?->name }}</td>
                <td align="left">{{ $property->area?->name }}</td>
                <td align="right">{{ $property->monthly_price }}</td>
                <td align="right">{{ $property->yearly_price }}</td>
                <td align="left">{{ $property->owner?->name }}</td>
                <td align="left">{{ $property->ownerRepresentative?->name }}</td>
                <td align="center">{{ $property->counter }}</td>
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
