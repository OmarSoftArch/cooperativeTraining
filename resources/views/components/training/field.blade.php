@props(['field', 'type' => 'text'])
<div>
    <label for="{{ $field }}" class="mb-2 block text-sm font-semibold">{{ __('application_fields.'.$field) }} <span class="text-rose-600">*</span></label>
    <input id="{{ $field }}" name="{{ $field }}" type="{{ $type }}" value="{{ old($field, $field === 'email' ? auth()->user()->email : '') }}" @if($type === 'date') data-training-date @endif @if($type === 'date' && $field === 'training_start_date') min="{{ now()->toDateString() }}" @endif @if($type === 'date' && $field === 'training_end_date') min="{{ now()->addDay()->toDateString() }}" @endif required class="w-full rounded-xl border border-[var(--brand-line)] bg-white px-4 py-3 shadow-sm focus:border-[var(--brand-blue-500)] focus:outline-none focus:ring-2 focus:ring-[var(--brand-blue-100)] @if($type === 'date') cursor-pointer @endif @error($field) border-rose-500 @enderror" @if(in_array($field, ['mobile','national_id','student_id'])) dir="ltr" @endif>
    @error($field)<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
</div>
