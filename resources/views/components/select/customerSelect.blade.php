@props(['customer' => null])
<select class="customers-ajax" {{ $attributes }}>
    @if($customer)
    <option value="{{$customer->id}}" selected>{{$customer->name}}</option>
    @endif
</select>
