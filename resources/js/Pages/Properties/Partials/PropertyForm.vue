<template>
    <div class="space-y-6">
        <!-- Informations générales -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations générales</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Titre -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Titre du bien <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="title"
                        v-model="form.title"
                        type="text"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Ex: Bel appartement F3 au centre-ville"
                    />
                    <p v-if="errors.title" class="mt-1 text-sm text-red-600">{{ errors.title }}</p>
                </div>

                <!-- Type de bien -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                        Type de bien <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="type"
                        v-model="form.type"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                        <option value="">Sélectionner un type</option>
                        <option value="appartement">Appartement</option>
                        <option value="maison">Maison</option>
                        <option value="bureau">Bureau</option>
                        <option value="commerce">Commerce</option>
                        <option value="terrain">Terrain</option>
                    </select>
                    <p v-if="errors.type" class="mt-1 text-sm text-red-600">{{ errors.type }}</p>
                </div>

                <!-- Statut -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="status"
                        v-model="form.status"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    >
                        <option value="available">Disponible</option>
                        <option value="rented">Loué</option>
                        <option value="maintenance">En maintenance</option>
                        <option value="unavailable">Indisponible</option>
                    </select>
                    <p v-if="errors.status" class="mt-1 text-sm text-red-600">{{ errors.status }}</p>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="4"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Décrivez le bien en détail..."
                    ></textarea>
                    <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}</p>
                </div>
            </div>
        </div>

        <!-- Localisation -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Localisation</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Adresse -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="address"
                        v-model="form.address"
                        type="text"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="123 Rue de la République"
                    />
                    <p v-if="errors.address" class="mt-1 text-sm text-red-600">{{ errors.address }}</p>
                </div>

                <!-- Ville -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                        Ville <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="city"
                        v-model="form.city"
                        type="text"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Yaoundé"
                    />
                    <p v-if="errors.city" class="mt-1 text-sm text-red-600">{{ errors.city }}</p>
                </div>

                <!-- Code postal -->
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                        Code postal
                    </label>
                    <input
                        id="postal_code"
                        v-model="form.postal_code"
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="00237"
                    />
                    <p v-if="errors.postal_code" class="mt-1 text-sm text-red-600">{{ errors.postal_code }}</p>
                </div>

                <!-- Quartier -->
                <div>
                    <label for="neighborhood" class="block text-sm font-medium text-gray-700 mb-2">
                        Quartier
                    </label>
                    <input
                        id="neighborhood"
                        v-model="form.neighborhood"
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Bastos"
                    />
                    <p v-if="errors.neighborhood" class="mt-1 text-sm text-red-600">{{ errors.neighborhood }}</p>
                </div>

                <!-- Coordonnées GPS (optionnel) -->
                <div>
                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Latitude
                    </label>
                    <input
                        id="latitude"
                        v-model="form.latitude"
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="3.8480"
                    />
                </div>

                <div>
                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                        Longitude
                    </label>
                    <input
                        id="longitude"
                        v-model="form.longitude"
                        type="text"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="11.5021"
                    />
                </div>
            </div>
        </div>

        <!-- Caractéristiques -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Caractéristiques</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Surface -->
                <div>
                    <label for="surface" class="block text-sm font-medium text-gray-700 mb-2">
                        Surface (m²) <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="surface"
                        v-model.number="form.surface"
                        type="number"
                        step="0.01"
                        min="0"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="75.5"
                    />
                    <p v-if="errors.surface" class="mt-1 text-sm text-red-600">{{ errors.surface }}</p>
                </div>

                <!-- Nombre de pièces -->
                <div>
                    <label for="rooms" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre de pièces
                    </label>
                    <input
                        id="rooms"
                        v-model.number="form.rooms"
                        type="number"
                        min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="4"
                    />
                    <p v-if="errors.rooms" class="mt-1 text-sm text-red-600">{{ errors.rooms }}</p>
                </div>

                <!-- Nombre de chambres -->
                <div>
                    <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre de chambres
                    </label>
                    <input
                        id="bedrooms"
                        v-model.number="form.bedrooms"
                        type="number"
                        min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="2"
                    />
                    <p v-if="errors.bedrooms" class="mt-1 text-sm text-red-600">{{ errors.bedrooms }}</p>
                </div>

                <!-- Nombre de salles de bain -->
                <div>
                    <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre de salles de bain
                    </label>
                    <input
                        id="bathrooms"
                        v-model.number="form.bathrooms"
                        type="number"
                        min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="1"
                    />
                    <p v-if="errors.bathrooms" class="mt-1 text-sm text-red-600">{{ errors.bathrooms }}</p>
                </div>

                <!-- Étage -->
                <div>
                    <label for="floor" class="block text-sm font-medium text-gray-700 mb-2">
                        Étage
                    </label>
                    <input
                        id="floor"
                        v-model.number="form.floor"
                        type="number"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="2"
                    />
                    <p v-if="errors.floor" class="mt-1 text-sm text-red-600">{{ errors.floor }}</p>
                </div>

                <!-- Année de construction -->
                <div>
                    <label for="year_built" class="block text-sm font-medium text-gray-700 mb-2">
                        Année de construction
                    </label>
                    <input
                        id="year_built"
                        v-model.number="form.year_built"
                        type="number"
                        min="1900"
                        :max="new Date().getFullYear()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        :placeholder="new Date().getFullYear()"
                    />
                    <p v-if="errors.year_built" class="mt-1 text-sm text-red-600">{{ errors.year_built }}</p>
                </div>
            </div>

            <!-- Équipements -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">
                    Équipements et commodités
                </label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input
                            v-model="form.has_parking"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <span class="text-sm text-gray-700">Parking</span>
                    </label>

                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input
                            v-model="form.has_elevator"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <span class="text-sm text-gray-700">Ascenseur</span>
                    </label>

                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input
                            v-model="form.has_balcony"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <span class="text-sm text-gray-700">Balcon</span>
                    </label>

                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input
                            v-model="form.has_garden"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <span class="text-sm text-gray-700">Jardin</span>
                    </label>

                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input
                            v-model="form.has_pool"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <span class="text-sm text-gray-700">Piscine</span>
                    </label>

                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input
                            v-model="form.has_security"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <span class="text-sm text-gray-700">Sécurité</span>
                    </label>

                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input
                            v-model="form.is_furnished"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <span class="text-sm text-gray-700">Meublé</span>
                    </label>

                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input
                            v-model="form.has_ac"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        />
                        <span class="text-sm text-gray-700">Climatisation</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Informations financières -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations financières</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Loyer mensuel -->
                <div>
                    <label for="rent_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Loyer mensuel (FCFA) <span class="text-red-500">*</span>
                    </label>
                    <input
                        id="rent_amount"
                        v-model.number="form.rent_amount"
                        type="number"
                        min="0"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="150000"
                    />
                    <p v-if="errors.rent_amount" class="mt-1 text-sm text-red-600">{{ errors.rent_amount }}</p>
                </div>

                <!-- Caution -->
                <div>
                    <label for="deposit_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Caution (FCFA)
                    </label>
                    <input
                        id="deposit_amount"
                        v-model.number="form.deposit_amount"
                        type="number"
                        min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="300000"
                    />
                    <p v-if="errors.deposit_amount" class="mt-1 text-sm text-red-600">{{ errors.deposit_amount }}</p>
                </div>

                <!-- Charges -->
                <div>
                    <label for="charges" class="block text-sm font-medium text-gray-700 mb-2">
                        Charges mensuelles (FCFA)
                    </label>
                    <input
                        id="charges"
                        v-model.number="form.charges"
                        type="number"
                        min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="25000"
                    />
                    <p v-if="errors.charges" class="mt-1 text-sm text-red-600">{{ errors.charges }}</p>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex justify-end space-x-4">
            <button
                type="button"
                @click="$emit('cancel')"
                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors duration-200"
            >
                Annuler
            </button>
            <button
                type="submit"
                @click.prevent="$emit('submit', form)"
                :disabled="processing"
                class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors duration-200 disabled:opacity-50"
            >
                <span v-if="!processing">{{ submitLabel }}</span>
                <span v-else>Enregistrement...</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { reactive, watch } from 'vue';

const props = defineProps({
    initialData: {
        type: Object,
        default: () => ({})
    },
    errors: {
        type: Object,
        default: () => ({})
    },
    processing: {
        type: Boolean,
        default: false
    },
    submitLabel: {
        type: String,
        default: 'Enregistrer'
    }
});

const emit = defineEmits(['submit', 'cancel']);

const form = reactive({
    title: props.initialData.title || '',
    type: props.initialData.type || '',
    status: props.initialData.status || 'available',
    description: props.initialData.description || '',
    address: props.initialData.address || '',
    city: props.initialData.city || '',
    postal_code: props.initialData.postal_code || '',
    neighborhood: props.initialData.neighborhood || '',
    latitude: props.initialData.latitude || '',
    longitude: props.initialData.longitude || '',
    surface: props.initialData.surface || null,
    rooms: props.initialData.rooms || null,
    bedrooms: props.initialData.bedrooms || null,
    bathrooms: props.initialData.bathrooms || null,
    floor: props.initialData.floor || null,
    year_built: props.initialData.year_built || null,
    has_parking: props.initialData.has_parking || false,
    has_elevator: props.initialData.has_elevator || false,
    has_balcony: props.initialData.has_balcony || false,
    has_garden: props.initialData.has_garden || false,
    has_pool: props.initialData.has_pool || false,
    has_security: props.initialData.has_security || false,
    is_furnished: props.initialData.is_furnished || false,
    has_ac: props.initialData.has_ac || false,
    rent_amount: props.initialData.rent_amount || null,
    deposit_amount: props.initialData.deposit_amount || null,
    charges: props.initialData.charges || null,
});

// Watch pour mettre à jour le formulaire si initialData change
watch(() => props.initialData, (newData) => {
    Object.assign(form, newData);
}, { deep: true });
</script>
