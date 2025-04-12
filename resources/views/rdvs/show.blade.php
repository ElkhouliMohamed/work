@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="px-4 py-5 sm:px-6 bg-gradient-to-r from-blue-600 to-indigo-700">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-white">
                            Appointment Details
                        </h3>
                    </div>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-indigo-800">
                        {{ ucfirst($rdv->statut) }}
                    </span>
                </div>
            </div>

            <!-- Main Content -->
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <!-- Date & Time -->
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Date & Time
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ \App\Helpers\AppHelper::formatDate($rdv->date) }}
                        </dd>
                    </div>

                    <!-- Contact Info -->
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Contact
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <span class="text-indigo-600 font-medium">
                                        {{ \App\Helpers\AppHelper::initials($rdv->contact->prenom . ' ' . $rdv->contact->nom) }}
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $rdv->contact->prenom }} {{ $rdv->contact->nom }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $rdv->contact->email }}
                                    </div>
                                </div>
                            </div>
                        </dd>
                    </div>

                    <!-- Notes -->
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Notes
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                {!! $rdv->notes ? nl2br(e($rdv->notes)) : '<span class="text-gray-400">No notes provided</span>' !!}
                            </div>
                        </dd>
                    </div>

                    <!-- Plans -->
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Associated Plans
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap gap-2">
                                @forelse($rdv->plans as $plan)
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $plan->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400">No plans associated</span>
                                @endforelse
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 px-4 py-4 sm:px-6 flex justify-between">
                <a href="{{ route('rdvs.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to list
                </a>
                <div class="space-x-3">
                    @can('update', $rdv)
                        <a href="{{ route('rdvs.edit', $rdv) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Edit Appointment
                        </a>
                    @endcan

                    @if ($rdv->canBeCancelled())
                        <form action="{{ route('rdvs.cancel', $rdv) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Cancel Appointment
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@php
    function initials($name)
    {
        $names = explode(' ', $name);
        $initials = '';

        foreach ($names as $n) {
            $initials .= strtoupper(substr($n, 0, 1));
            if (strlen($initials) >= 2) {
                break;
            }
        }

        return $initials;
    }
@endphp
