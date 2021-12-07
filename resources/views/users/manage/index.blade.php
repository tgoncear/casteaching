<x-casteachin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('Users')}}
        </h2>
    </x-slot>
    <div class="flex flex-col mt-10 mx-auto sm:px-6 lg:px-8 w-full max-w-7xl">

        <x-status></x-status>

        @can('users_manage_create')
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 w-screen">
                <div class="py-2 align-middle sm:px-6 lg:px-8 w-screen">
                    <div class="p-4">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <div class="px-4 sm:px-0">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Usuari</h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        Informació bàsica de l'usuari
                                    </p>
                                </div>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <form data-qa="form_user_create" action="#" method="POST" >
                                    @csrf
                                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">

                                            <div>
                                                <label for="name" class="block text-sm font-medium text-gray-700">
                                                    Name
                                                </label>
                                                <div class="mt-1">
                                                    <input required id="name" name="name" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md p-2" placeholder="Nom del usuari"></input>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-500">
                                                    Nom de l'usuari
                                                </p>
                                            </div>

                                            <div>
                                                <label for="email" class="block text-sm font-medium text-gray-700">
                                                    Email
                                                </label>
                                                <div class="mt-1">
                                                    <input required id="email" type="email" name="email" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="prova@gmail.com"></input>
                                                </div>
                                                <p class="mt-2 text-sm text-gray-500">
                                                    Email
                                                </p>
                                            </div>

                                            <div class="grid grid-cols-3 gap-6">
                                                <div class="col-span-3 sm:col-span-2">
                                                    <label for="password" class="block text-sm font-medium text-gray-700">
                                                        Password
                                                    </label>
                                                    <div class="mt-1 flex rounded-md shadow-sm">
                                                        <input required type="password" name="password" id="password" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" placeholder="">
                                                    </div>
                                                </div>
                                            </div>



                                        </div>
                                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Crear
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endcan

        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle sm:px-6 lg:px-8 w-screen">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Users
                        </h3>
                    </div>
                    <table class="min-w-full w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Id
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Superadmin
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Odd row -->
                        @foreach($users as $user)
                            @if($loop->odd)
                                <tr class="bg-white">
                            @else
                                <tr class="bg-gray-50">
                            @endif
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $user->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->superadmin }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="/users/{{$user->id}}" target="_blank" class="text-indigo-600 hover:text-indigo-900">Show</a>
                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form class="inline" action="/manage/users/{{$user->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <a href="/users/{{$user->id}}" class="text-indigo-600 hover:text-indigo-900"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">Delete</a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-casteachin-layout>
