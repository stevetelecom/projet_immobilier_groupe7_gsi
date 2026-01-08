<template>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Documents</h3>
            <span class="text-sm text-gray-600">{{ documents.length }} document{{ documents.length > 1 ? 's' : '' }}</span>
        </div>

        <!-- Zone de upload -->
        <div class="mb-6">
            <label
                class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-gray-50 transition-colors duration-200"
                :class="{ 'border-indigo-500 bg-indigo-50': isDragging }"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="handleDrop"
            >
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-12 h-12 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="mb-2 text-sm text-gray-600">
                        <span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez
                    </p>
                    <p class="text-xs text-gray-500">PDF, DOC, DOCX, XLS, XLSX (MAX. 10MB par fichier)</p>
                </div>
                <input
                    ref="fileInput"
                    type="file"
                    multiple
                    accept=".pdf,.doc,.docx,.xls,.xlsx"
                    class="hidden"
                    @change="handleFileSelect"
                />
            </label>
        </div>

        <!-- Liste des documents -->
        <div v-if="documents.length > 0" class="space-y-3">
            <div
                v-for="(document, index) in documents"
                :key="document.id || index"
                class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200"
            >
                <!-- Icône et info -->
                <div class="flex items-center space-x-4 flex-1 min-w-0">
                    <!-- Icône selon le type -->
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 flex items-center justify-center rounded-lg"
                            :class="getDocumentIconClass(document)">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Informations du document -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ document.name || document.original_name }}
                        </p>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="text-xs text-gray-500">
                                {{ getDocumentType(document) }}
                            </span>
                            <span v-if="document.size" class="text-xs text-gray-500">
                                {{ formatFileSize(document.size) }}
                            </span>
                            <span v-if="document.uploaded_at" class="text-xs text-gray-500">
                                {{ formatDate(document.uploaded_at) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-2 ml-4">
                    <!-- Télécharger -->
                    <a
                        :href="getDownloadUrl(document)"
                        target="_blank"
                        class="p-2 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-200"
                        title="Télécharger"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                    </a>

                    <!-- Supprimer -->
                    <button
                        @click="deleteDocument(document, index)"
                        class="p-2 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                        title="Supprimer"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Indicateur de chargement -->
                <div
                    v-if="document.uploading"
                    class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center rounded-lg"
                >
                    <div class="text-center">
                        <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto mb-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-xs text-gray-600">Upload...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- État vide -->
        <div v-else class="text-center py-12">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="mt-4 text-sm text-gray-600">Aucun document pour le moment</p>
            <p class="mt-1 text-xs text-gray-500">Ajoutez des documents (diagnostics, plans, etc.)</p>
        </div>

        <!-- Messages d'erreur -->
        <div v-if="uploadErrors.length > 0" class="mt-4 space-y-2">
            <div
                v-for="(error, index) in uploadErrors"
                :key="index"
                class="bg-red-50 border border-red-200 rounded-lg p-3 text-sm text-red-800 flex items-start"
            >
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ error }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    propertyId: {
        type: [Number, String],
        required: true
    },
    documents: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['documents-updated']);

const fileInput = ref(null);
const isDragging = ref(false);
const uploadErrors = ref([]);

const allowedTypes = [
    'application/pdf',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

const handleFileSelect = (event) => {
    const files = Array.from(event.target.files);
    uploadDocuments(files);
    event.target.value = ''; // Reset input
};

const handleDrop = (event) => {
    isDragging.value = false;
    const files = Array.from(event.dataTransfer.files);
    uploadDocuments(files);
};

const uploadDocuments = async (files) => {
    uploadErrors.value = [];

    // Validation
    const validFiles = [];
    files.forEach(file => {
        if (!allowedTypes.includes(file.type)) {
            uploadErrors.value.push(`${file.name} : Format non supporté`);
            return;
        }
        if (file.size > 10 * 1024 * 1024) {
            uploadErrors.value.push(`${file.name} : Fichier trop volumineux (max 10MB)`);
            return;
        }
        validFiles.push(file);
    });

    if (validFiles.length === 0) return;

    // Upload via Inertia
    const formData = new FormData();
    validFiles.forEach(file => {
        formData.append('documents[]', file);
    });

    router.post(
        route('properties.documents.upload', props.propertyId),
        formData,
        {
            preserveScroll: true,
            onSuccess: () => {
                emit('documents-updated');
            },
            onError: (errors) => {
                if (errors.documents) {
                    uploadErrors.value.push(errors.documents);
                }
            }
        }
    );
};

const deleteDocument = (document, index) => {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce document ?')) {
        return;
    }

    if (document.id) {
        router.delete(
            route('properties.documents.delete', { 
                property: props.propertyId, 
                document: document.id 
            }),
            {
                preserveScroll: true,
                onSuccess: () => {
                    emit('documents-updated');
                }
            }
        );
    }
};

const getDocumentType = (document) => {
    const extension = document.name?.split('.').pop()?.toUpperCase() || 
                     document.original_name?.split('.').pop()?.toUpperCase() ||
                     'DOC';
    return extension;
};

const getDocumentIconClass = (document) => {
    const type = getDocumentType(document);
    
    if (type === 'PDF') {
        return 'bg-red-100 text-red-600';
    } else if (['DOC', 'DOCX'].includes(type)) {
        return 'bg-blue-100 text-blue-600';
    } else if (['XLS', 'XLSX'].includes(type)) {
        return 'bg-green-100 text-green-600';
    }
    return 'bg-gray-100 text-gray-600';
};

const formatFileSize = (bytes) => {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });
};

const getDownloadUrl = (document) => {
    if (document.id) {
        return route('properties.documents.download', { 
            property: props.propertyId, 
            document: document.id 
        });
    }
    return document.url || document.path || '#';
};
</script>
