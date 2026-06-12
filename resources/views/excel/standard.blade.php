<table>
    <thead>
        <tr>
            <th align="center" colspan="15">
                <b>{{ trans('page.standard') }}</b>
            </th>
        </tr>
        <tr>
            <td colspan="15"></td>
        </tr>
        <tr>
            <th align="center" colspan="15">
                {{ trans('field.printed_at') }} : {{ now()->isoFormat('LLLL') }}
            </th>
        </tr>
        <tr>
            <td colspan="15"></td>
        </tr>
        <tr>
            <th align="center"><b>{{ trans('field.#') }}</b></th>
            <th align="center"><b>{{ trans('field.id') }}</b></th>
            <th align="center"><b>{{ trans('field.title') }}</b></th>
            <th align="center"><b>{{ trans('field.title_id') }}</b></th>
            <th align="center"><b>{{ trans('field.title_zh') }}</b></th>
            <th align="center"><b>{{ trans('field.title_fr') }}</b></th>
            <th align="center"><b>{{ trans('field.description') }}</b></th>
            <th align="center"><b>{{ trans('field.description_id') }}</b></th>
            <th align="center"><b>{{ trans('field.description_zh') }}</b></th>
            <th align="center"><b>{{ trans('field.description_fr') }}</b></th>
            <th align="center"><b>{{ trans('field.active') }}</b></th>
            <th align="center"><b>{{ trans('field.created_by') }}</b></th>
            <th align="center"><b>{{ trans('field.updated_by') }}</b></th>
            <th align="center"><b>{{ trans('field.created_at') }}</b></th>
            <th align="center"><b>{{ trans('field.updated_at') }}</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($standards as $standard)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{ $standard->id }}</td>
                <td align="left">{{ $standard->title }}</td>
                <td align="left">{{ $standard->title_id }}</td>
                <td align="left">{{ $standard->title_zh }}</td>
                <td align="left">{{ $standard->title_fr }}</td>
                <td align="left">{{ $standard->short_description }}</td>
                <td align="left">{{ $standard->short_description_id }}</td>
                <td align="left">{{ $standard->short_description_zh }}</td>
                <td align="left">{{ $standard->short_description_fr }}</td>
                <td align="left">{{ $standard->description }}</td>
                <td align="left">{{ $standard->description_id }}</td>
                <td align="left">{{ $standard->description_zh }}</td>
                <td align="left">{{ $standard->description_fr }}</td>
                <td align="left">{{ $standard->icon }}</td>
                <td align="center">{{ Str::yesNo($standard->is_active) }}</td>
                <td align="left">{{ $standard->createdBy?->name }}</td>
                <td align="left">{{ $standard->updatedBy?->name }}</td>
                <td align="left">{{ $standard->created_at }}</td>
                <td align="left">{{ $standard->updated_at }}</td>
            </tr>
        @empty
            <tr>
                <td align="center" colspan="15">
                    {{ trans('message.no_data_available') }}
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="15"></td>
        </tr>
    </tfoot>
</table>
