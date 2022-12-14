@extends('admin.admin-master')
@section('admin')
 
 <!-- Content -->
 <div class="h-screen w-full overflow-y-auto">
    <div class="px-8 py-4">
        <p class="pb-6 pt-3 font-bold uppercase text-sm leading-7 tracking-wider text-gray-600"><span class="flex items-center gap-1"> <x-ri-home-3-fill class="w-4 h-4" /> Home<x-heroicon-o-arrow-long-right class="w-5 h-6" />Menu<x-heroicon-o-arrow-long-right class="w-5 h-6" />Dashboard</span></p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-8">

            {{-- First Container --}}
            <div class="p-6 bg-white rounded-lg flex items-center h-32 shadow-md">
                <div class="w-3/5 flex justify-start">

                    <ul>
                        <li class="font-bold text-gray-400">College List</li>
                        <li class="font-extrabold text-slate-800 text-xl">{{ App\Models\Department::count() }}</li>
                    </ul>

                </div>

                <div class="w-2/5 flex justify-end">
                    <x-ri-file-list-3-fill class="bg-gradient-to-r from-cyan-400 to-blue-600 rounded-lg p-2 w-12" />
                </div>
            </div>

            {{-- Second Container --}}
            <div class="p-6 bg-white rounded-lg flex items-center h-32 shadow-md">
                <div class="w-3/5 flex justify-start">

                    <ul>
                        <li class="font-bold text-gray-400">Program List</li>
                        <li class="font-extrabold text-slate-800 text-xl">{{ App\Models\Curriculum::count() }}</li>
                    </ul>

                </div>

                <div class="w-2/5 flex justify-end">
                    <x-ri-list-check-2 class="bg-gradient-to-r from-cyan-400 to-cyan-600 rounded-lg p-2 w-12" />
                </div>
            </div>

            {{-- Third Container --}}
            <div class="p-6 bg-white rounded-lg flex items-center h-32 shadow-md">
                <div class="w-3/5 flex justify-start">

                    <ul>
                        <li class="font-bold text-gray-400">Verified Students</li>
                        <li class="font-extrabold text-slate-800 text-xl">{{ App\Models\User::where('email_status', 1)->count() }}</li>
                    </ul>

                </div>

                <div class="w-2/5 flex justify-end">
                    <x-ri-user-follow-fill class="bg-gradient-to-r from-green-400 to-green-600 rounded-lg p-2 w-12" />
                </div>
            </div>

            {{-- Fourth Container --}}
            <div class="p-6 bg-white rounded-lg flex items-center h-32 shadow-md">
                <div class="w-3/5 flex justify-start">

                    <ul>
                        <li class="font-bold text-gray-400">Not Verified Students</li>
                        <li class="font-extrabold text-slate-800 text-xl">{{ App\Models\User::where('email_status', 0)->count() }}</li>
                    </ul>

                </div>

                <div class="w-2/5 flex justify-end">
                    <x-ri-user-unfollow-fill class="bg-gradient-to-r from-rose-400 to-red-600 rounded-lg p-2 w-12" />
                </div>
            </div>

            {{-- Fifth Container --}}
            <div class="p-6 bg-white rounded-lg flex items-center h-32 shadow-md">
                <div class="w-3/5 flex justify-start">

                    <ul>
                        <li class="font-bold text-gray-400">Approved Archives</li>
                        <li class="font-extrabold text-slate-800 text-xl">{{ App\Models\Archive::where('archive_status', 1)->count() }}</li>
                    </ul>

                </div>

                <div class="w-2/5 flex justify-end">
                    <x-ri-inbox-archive-fill class="bg-gradient-to-r from-lime-400 to-lime-600 rounded-lg p-2 w-12" />
                </div>
            </div>

            {{-- Sixth Container --}}
            <div class="p-6 bg-white rounded-lg flex items-center h-32 shadow-md">
                <div class="w-3/5 flex justify-start">

                    <ul>
                        <li class="font-bold text-gray-400">Pending Archives</li>
                        <li class="font-extrabold text-slate-800 text-xl">{{ App\Models\Archive::where('archive_status', 0)->count() }}</li>
                    </ul>

                </div>

                <div class="w-2/5 flex justify-end">
                    <x-ri-inbox-unarchive-fill class="bg-gradient-to-r from-amber-400 to-amber-600 rounded-lg p-2 w-12" />
                </div>
            </div>

            <div class="rounded-lg shadow-md bg-white md:col-span-2 lg:col-span-3 mb-4">
                <div class="overflow-x-auto relative sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <h5 class="p-4 font-bold text-gray-400">Latest Thesis File Uploaded</h5>
                            <tr>
                                <th class="py-3 px-8">Uploader's Name</th>
                                <th class="py-3 px-8">Title Name</th>
                                <th class="py-3 px-8">Department</th>
                                <th class="py-3 px-8">Curriculum</th>
                                <th class="py-3 px-8">Status</th>
                                <th class="py-3 px-8">Upload Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($archives as $archive)
                            <tr class="bg-white border-b">
                                <th scope="row" class="py-4 px-8 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $archive->user->last_name . ", " . $archive->user->first_name . " " . $archive->user->middle_name[0] . "." }}
                                </th>
                                <td class="py-4 px-8">
                                    <a href="{{ route('admin.view.archive-list', $archive->archive_code) }}" class="text-blue-500 hover:text-blue-700 duration-150"> {{ \Illuminate\Support\Str::limit($archive->title, 90, '...') }} </a>
                                </td>
                                <td class="py-4 px-8">
                                    {{ $archive->department->dept_name }}
                                </td>
                                <td class="py-4 px-8">
                                    {{ $archive->curriculum->curr_name }}
                                </td>
                                <td class="py-4 px-8">
                                    @if($archive->archive_status == 1)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-green-300 to-green-400 text-green-800">
                                        Published
                                    </span>
                                    @elseif($archive->archive_status == 2)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-red-300 to-red-400 text-red-800">
                                        Unpublished
                                    </span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gradient-to-r from-gray-300 to-gray-400 text-gray-800">
                                        Pending
                                    </span>
                                    @endif
                                </td>
                                <td class="py-4 px-8">
                                    {{ $archive->created_at->format('m/d/Y') }}
                                </td>
                            </tr>
                            @empty
                                <tr
                                wire:loading.class.delay="opacity-50"
                                class="odd:bg-white even:bg-slate-50 focus:outline-none h-26 text-sm leading-none text-gray-800 bg-white border-b border-t border-gray-100"
                            >
                                <td colspan="8" class="pl-8">
                                <div class="flex items-center justify-center">
                                    <div>
                                    <p class="text-xl py-8 font-medium leading-none text-gray-400">No thesis found...</p>
                                    </div>
                                </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection