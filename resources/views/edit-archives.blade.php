@extends('master')
@section('user')

    @php
        if (count($errors) > 0) {
        RealRashid\SweetAlert\Facades\Alert::warning("Fields is Required", "You need to fill in the input fields.")->showConfirmButton('Okay', '#2678c5')->autoClose(6000);
        }
    @endphp

<div class="overflow-hidden bg-white shadow-xl rounded-lg max-w-xl md:max-w-2xl lg:max-w-4xl xl:max-w-7xl mx-8 sm:mx-auto my-8 relative">
    <div class="px-4 py-5 sm:px-6">
        <p class="py-2 text-sm md:text-lg font-medium">Update Archive {{ $editArchiveData->archive_code }} Details</p>
        <div class="py-10 border-t border-gray-300 space-y-4">
            <dl>
                <form x-data="{ buttonDisabled: false }" x-on:submit="buttonDisabled = true" action="{{ route('update.archives', $editArchiveData->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="bg-gray px-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <div class="relative md:px-8">
                        <label for="title" class="text-sm font-semibold text-gray-900">Project Title:</label>
                    <input type="text" name="title" id="title" placeholder="Project Title" class="w-full text-black h-10 mt-2 bg-white focus:ring-green-500 focus:border-green-500 rounded-md px-3 focus:outline-none" value="{{ $editArchiveData->title }}" autofocus>
                    </div>
                    <div class="relative md:px-8 pt-8 sm:pt-0">
                        <label for="year" class="text-sm font-semibold text-gray-900">Year:</label>
                        <select id="year" name="year" class="w-full text-black h-10 mt-2 bg-white focus:ring-green-500 focus:border-green-500 rounded-md px-3 focus:outline-none">
                            <option value="0" hidden>~ Select Year ~</option>
                            @for ($year=date('Y'); $year >= 2000; $year--)
                            <option value="{{ $year }}"
                            @if($year == $editArchiveData->year)
                            selected
                            @endif
                            > {{ $year }} </option>
                            @endfor
                            </select>
                    </div>
                    <div class="relative md:px-8 pt-8 sm:pt-0">
                        <label for="year" class="text-sm font-semibold text-gray-900">Research Agenda:</label>
                        <select name="research_agenda" id="research_agenda" class="border mt-2 mb-8 px-3 border-gray-500 text-gray-900 rounded-md focus:ring-1 focus:ring-green-500 focus:border-green-500 placeholder:font-sans placeholder:font-light focus:outline-none block w-full">
                            <option value="0" hidden>~ Select Research Agenda ~</option>
                            @foreach ($agendaData as $agenda)
                            <option value="{{ $agenda->agenda_name }}"
                                @if($editArchiveData->research_agenda_id == $agenda->id)
                                selected
                                @endif
                    > {{ $agenda->agenda_name }} </option>
                            @endforeach
                            </select>
                    </div>
                </div>
                
                <div class="bg-gray px-4 py-5 sm:grid sm:grid-cols-1 sm:gap-4 sm:px-6">
                    <div class="relative md:px-8 space-y-2">
                        <label for="abstract" class="text-sm font-semibold text-gray-900">Abstract:</label>
                    <textarea name="abstract" id="abstract">{{ $editArchiveData->abstract }}</textarea>
                    </div>
                </div>
                
                <div class="bg-gray px-4 py-5 sm:grid sm:grid-cols-1 sm:gap-4 sm:px-6">
                    <div class="relative md:px-8 space-y-2">
                        <label for="members" class="text-sm font-semibold text-gray-900">Project Members:</label>
                    <textarea name="members" id="members">{{ $editArchiveData->members }}</textarea>
                    </div>
                </div>
                
                <div class="bg-gray px-4 py-5 sm:grid sm:grid-cols-1 sm:gap-4 sm:px-6">
                    <div class="relative md:px-8 space-y-2">
                    <label for="document_path" class="text-sm font-semibold text-gray-900">Project Document (PDF File only)</label>
                    <input id="document_path" name="document_path" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none" type="file">
                    </div>
                </div>

                <div class="bg-gray px-4 py-5 sm:grid sm:grid-cols-1 sm:gap-4 sm:px-6">
                    <div class="relative md:px-8 space-y-2">
                        <label for="signature_path" class="text-sm font-semibold text-gray-900">E-Signature Document (PDF File only)</label>
                        <input id="signature_path" accept="application/pdf" name="signature_path" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none" type="file">
                    </div>
                </div>
                
                <div class="bg-white mx-6 xl:mx-32 py-6 grid grid-cols-2 gap-4 px-6">
                <a href="{{ route('view.archives', $editArchiveData->id) }}" x-bind:class="buttonDisabled ? 'cursor-not-allowed pointer-events-none' : 'cursor-pointer' " class="cursor-pointer text-xs sm:text-sm md:text-base w-full md:w-auto flex justify-center items-center space-x-4 font-sans font-bold text-slate-800 rounded-md p-2 border-gray-700 bg-transparent shadow-cyan-100 hover:bg-slate-50 shadow-sm hover:shadow-lg border transition hover:-translate-y-0.5 duration-150">Cancel</a>
                <x-primary-button x-bind:disabled="buttonDisabled" x-bind:class="buttonDisabled ? 'cursor-not-allowed' : 'cursor-pointer' " class="mx-2 py-3 text-xs sm:text-sm md:text-base">Update</x-primary-button>
                </div>
                </form>
                </dl>
        </div>
    </div>
</div>
@endsection

@section('editor')
<script>
    ClassicEditor
        .create( document.querySelector( '#abstract' ) )
        .catch( error => {
            console.error( error );
        } );

        ClassicEditor
        .create( document.querySelector( '#members' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection