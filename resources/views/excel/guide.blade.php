<table>
    <thead>
        <tr>
            <th align="center" colspan="6">
                <b>{{ trans('page.guide') }}</b>
            </th>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <th align="center" colspan="6">
                {{ trans('field.printed_at') }} : {{ now()->isoFormat('LLLL') }}
            </th>
        </tr>
        <tr>
            <td colspan="6"></td>
        </tr>
        <tr>
            <th valign="middle" align="center">
                <b>{{ trans('field.#') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.guide_category_id') }}</b>
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
                <b>{{ trans('field.google_file_id') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.image_url') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.show') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.slug') }}</b>
            </th>
            <th valign="middle" align="center">
                <b>{{ trans('field.counter') }}</b>
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
        @forelse ($guides as $guide)
            <tr>
                <td valign="middle" align="center">
                    {{ $loop->iteration }}
                </td>
                <td valign="middle" align="center">
                    {{ $guide->id }}
                </td>
                <td valign="middle" align="left">
                    {{ $guide->category?->name }}
                </td>
                <td valign="middle" align="left">
                    {{ $guide->title }}
                </td>
                <td valign="middle" align="left">
                    {{ $guide->title_id }}
                </td>
                <td valign="middle" align="left">
                    {{ $guide->title_zh }}
                </td>
                <td valign="middle" align="left">
                    {{ $guide->google_file_id }}
                </td>
                <td valign="middle" align="left">
                    {{ $guide->image_url }}
                </td>
                <td valign="middle" align="center">
                    {{ Str::yesNo($guide->is_show) }}
                </td>
                <td valign="middle" align="center">
                    {{ Str::yesNo($guide->is_active) }}
                </td>
                <td valign="middle" align="left">
                    {{ $guide->slug }}
                </td>
                <td valign="middle" align="center">
                    {{ $guide->counter }}
                </td>
                <td valign="middle" align="left">
                    {{ $guide->createdBy?->name }}
                </td>
                <td valign="middle" align="left">
                    {{ $guide->updatedBy?->name }}
                </td>
                <td valign="middle" align="left">
                    {{ $guide->created_at }}
                </td>
                <td valign="middle" align="left">
                    {{ $guide->updated_at }}
                </td>
            </tr>
        @empty
            <tr>
                <td align="center" colspan="6">
                    {{ trans('message.no_data_available') }}
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6"></td>
        </tr>
    </tfoot>
</table>
