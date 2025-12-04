@props([
    'question',
    'answer',
])

<div x-data="{show:false}" class="w-full mt-4">
    <div @click="show = !show" class="flex justify-between hover:bg-gray-200 bg-gray-100 p-4 rounded-lg cursor-pointer">
        {{ $question }}
        <x-icon x-show="show" name="chevron-up"/>
        <x-icon x-show="!show" name="chevron-down"/>
    </div>
    <span x-show="show" class="block mx-4 mt-2 text-gray-500">{{ $answer }}</span>
</div>
