<table>
    <thead>
        <tr>
            <th align="center" colspan="18">
                <b>{{ trans('page.contact') }}</b>
            </th>
        </tr>
        <td colspan="18"></td>
        </tr>
        <tr>
            <th align="center" colspan="18">
                {{ trans('field.printed_at') }} : {{ now()->isoFormat('LLLL') }}
            </th>
        </tr>
        <tr>
            <td colspan="18"></td>
        </tr>
        <tr>
            <th align="center"><b>{{ trans('field.#') }}</b></th>
            <th align="center"><b>{{ trans('field.id') }}</b></th>
            <th align="center"><b>{{ trans('field.code') }}</b></th>
            <th align="center"><b>{{ trans('field.name') }}</b></th>
            <th align="center"><b>{{ trans('field.first_name') }}</b></th>
            <th align="center"><b>{{ trans('field.last_name') }}</b></th>
            <th align="center"><b>{{ trans('field.company') }}</b></th>
            <th align="center"><b>{{ trans('field.email') }}</b></th>
            <th align="center"><b>{{ trans('field.phone') }}</b></th>
            <th align="center"><b>{{ trans('field.area') }}</b></th>
            <th align="center"><b>{{ trans('field.bedroom') }}</b></th>
            <th align="center"><b>{{ trans('field.rental_type') }}</b></th>
            <th align="center"><b>{{ trans('field.message') }}</b></th>
            <th align="center"><b>{{ trans('field.district') }}</b></th>
            <th align="center"><b>{{ trans('field.created_by') }}</b></th>
            <th align="center"><b>{{ trans('field.updated_by') }}</b></th>
            <th align="center"><b>{{ trans('field.created_at') }}</b></th>
            <th align="center"><b>{{ trans('field.updated_at') }}</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($contacts as $contact)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{ $contact->id }}</td>
                <td align="center">{{ $contact->code }}</td>
                <td align="left">{{ $contact->name }}</td>
                <td align="left">{{ $contact->first_name }}</td>
                <td align="left">{{ $contact->last_name }}</td>
                <td align="left">{{ $contact->company }}</td>
                <td align="left">{{ $contact->email }}</td>
                <td align="left">'{{ $contact->phone }}</td>
                <td align="left">{{ $contact->area?->district?->name }}</td>
                <td align="left">{{ $contact->area?->name }}</td>
                <td align="left">{{ $contact->bedroom?->description() }}</td>
                <td align="left">{{ $contact->rental_type?->description() }}</td>
                <td align="left">{{ $contact->message }}</td>
                <td align="left">{{ $contact->createdBy?->name }}</td>
                <td align="left">{{ $contact->updatedBy?->name }}</td>
                <td align="left">{{ $contact->created_at }}</td>
                <td align="left">{{ $contact->updated_at }}</td>
            </tr>
        @empty
            <tr>
                <td align="center" colspan="18">
                    {{ trans('message.no_data_available') }}
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="18"></td>
        </tr>
    </tfoot>
</table>
