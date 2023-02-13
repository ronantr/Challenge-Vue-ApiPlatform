<script setup></script>

<template>
    <nav>
        <ul class="flex flex-row gap-3">
            <li>
                <router-link to="/admin/theater-groups"
                    >Theater groups</router-link
                >
            </li>
            <li>
                <router-link to="/admin/users">Users</router-link>
            </li>
        </ul>
    </nav>
    <h1 class="text-xl">Admin</h1>
    <router-view />
</template>
