<template>
    <AppLayout title="Profil">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <UpdateProfileInformationForm :mustVerifyEmail="mustVerifyEmail" :status="status" />
                <UpdatePasswordForm />
                <DeleteUserForm />
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Components/Layout/AppLayout.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});
</script>
