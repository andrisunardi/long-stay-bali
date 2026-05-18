<table>
    <thead>
        <tr>
            <th align="center" colspan="11">
                <b>{{ trans('page.guide_category') }}</b>
            </th>
        </tr>
        <tr>
            <td colspan="11"></td>
        </tr>
        <tr>
            <th align="center" colspan="11">
                {{ trans('field.printed_at') }} : {{ now()->isoFormat('LLLL') }}
            </th>
        </tr>
        <tr>
            <td colspan="11"></td>
        </tr>
        <tr>
            <th valign="middle" align="center">
                <b>{{ trans('field.#') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.name') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.name_id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.name_zh') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.name_fr') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.show') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.active') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('index.total') }} {{ trans('page.guide') }}</b>
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
        @forelse ($guideCategories as $guideCategory)
            <tr>
                <td valign="middle" align="center">
                    {{ $loop->iteration }}
                </td>
                <td valign="middle" align="center">
                    {{ $guideCategory->id }}
                </td>
                <td valign="middle" align="left">
                    {{ $guideCategory->name }}
                </td>
                <td valign="middle" align="left">
                    {{ $guideCategory->name_id }}
                </td>
                <td valign="middle" align="left">
                    {{ $guideCategory->name_zh }}
                </td>
                <td valign="middle" align="left">
                    {{ $guideCategory->name_fr }}
                </td>
                <td valign="middle" align="center">
                    {{ Str::yesNo($guideCategory->is_show) }}
                </td>
                <td valign="middle" align="center">
                    {{ Str::yesNo($guideCategory->is_active) }}
                </td>
                <td valign="middle" align="center">
                    {{ $guideCategory->guides_count }}
                </td>
                <td valign="middle" align="left">
                    {{ $guideCategory->createdBy?->name }}
                </td>
                <td valign="middle" align="left">
                    {{ $guideCategory->updatedBy?->name }}
                </td>
                <td valign="middle" align="left">
                    {{ $guideCategory->created_at }}
                </td>
                <td valign="middle" align="left">
                    {{ $guideCategory->updated_at }}
                </td>
            </tr>
        @empty
            <tr>
                <td align="center" colspan="11">
                    {{ trans('message.no_data_available') }}
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="11"></td>
        </tr>
    </tfoot>
</table>
