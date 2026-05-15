<table>
    <thead>
        <tr>
            <th align="center" colspan="20">
                <b>{{ trans('page.value') }}</b>
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
            <th valign="middle" align="center">
                <b>{{ trans('field.#') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.title') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.title_id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.title_zh') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.title_fr') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.short_description') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.short_description_id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.short_description_zh') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.short_description_fr') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.description') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.description_id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.description_zh') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.description_fr') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.icon') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.active') }}</b>
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
        @forelse ($values as $value)
            <tr>
                <td valign="middle" align="center">
                    {{ $loop->iteration }}
                </td>
                <td valign="middle" align="center">
                    {{ $value->id }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->title }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->title_id }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->title_zh }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->title_fr }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->short_description }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->short_description_id }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->short_description_zh }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->short_description_fr }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->description }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->description_id }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->description_zh }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->description_fr }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->icon }}
                </td>
                <td valign="middle" align="center">
                    {{ Str::yesNo($value->is_active) }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->createdBy?->name }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->updatedBy?->name }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->created_at }}
                </td>
                <td valign="middle" align="left">
                    {{ $value->updated_at }}
                </td>
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
