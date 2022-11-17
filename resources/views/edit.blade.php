<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dash.edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('edit') }}">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('dash.name')" />

                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$productTranslation->name" required autofocus />

                            <x-input-error :messages="$errors->get('dash.name')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('dash.reference')" />

                            <x-text-input id="reference" class="block mt-1 w-full" type="text" name="reference" :value="$product->reference" />

                            <x-input-error :messages="$errors->get('dash.reference')" class="mt-2" />
                        </div>
                        <x-text-input id="id" class="block mt-1 w-full" type="hidden" name="id" :value="$product->id_product"/>


                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('dash.edit') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
