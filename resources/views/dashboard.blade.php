<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table mt-3  text-left">
                        <thead>
                        <tr>
                            <th scope="col">{{ trans('dash.product_id') }}</th>
                            <th scope="col">{{ trans(('dash.reference')) }}</th>
                            <th scope="col">Ean13</th>
                            <th scope="col">{{ trans(('dash.name')) }}</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{!! $product->id_product !!}</td>
                                <td>{!! $product->reference !!}</td>
                                <td>{!! $product->ean13 !!}</td>
                                <td>{!! App\Models\ProductTranslation::query()->where('id_product', $product->id_product)->where('language_code', app()->getLocale())->first()->name !!}</td>
                                <td><a href="{{ url('/generate') }}/{{$product->id_product}}">{{ trans('dash.generate_ean13') }}</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">{{ trans('dash.no_products') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
