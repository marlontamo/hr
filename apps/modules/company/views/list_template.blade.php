<tr class="record">
    @if( $can_delete != '0')
        <td><input type="checkbox" value="{{ $record_id }}" class="record-checker checkboxes"></td>
    @else
        <td class="hidden-xs"></td>
    @endif

    <!-- <td class="hidden-xs"><a href="#"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAABF0lEQVRoge2UsQ7DIAxE+/+f4o3NCxsbIzufwC/QyYg4rVRC1GulG24gwPmegTxaa/2f9UAHIAA6AAHQAQiADkAAdAACoAMQAB2AAOgABEAH+BpAKaWLSE8pnb6ZSilLxe/w/BgghHAqJiI9xthba11Vu4gsAdzh+RFASml0xIr57tmaWuuYsyAxxlM3Vz0vA9Rah+lKtyy07bN1O56XAFS1q+qh6Dw/31e/993cjucSQM55HKEv5sfW8fm47dvc/V3PJQA7Qi9VHUHsXtv9zTkfxv5vsuN5+RG/6o5/cP6h2h/G9oUQtj1vBZivg8k6ZY/Tj/1dX/HcBvhVEQAtAqBFALQIgBYB0CIAWgRAiwBoEQAtAqD1BBs6m19czwjTAAAAAElFTkSuQmCC" data-src="holder.js/48x48" alt="48x48" style="width: 48px; height: 48px;"></a></td> -->
    <td>
        <a href="{{ $detail_url }}">{{ $users_company_company }}</a>
        <br>
        <span class="small">{{ $users_company_company_code }}</span>
    </td>
    <td>
            {{ $users_company_address }}<br>
            {{ $users_company_city_id }}, {{ $users_company_country_id }} {{ $users_company_zipcode }}</td>
    <td>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="{{ $edit_url }}"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-xs text-muted" href="#" data-close-others="true" data-toggle="dropdown"><i class="fa fa-gear"></i> Options</a>
            <ul class="dropdown-menu pull-right">
                {{ $options }}
            </ul>
        </div>
    </td>
</tr>