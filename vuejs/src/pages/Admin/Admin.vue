<script setup></script>

<template>
    <nav>
        <ul>
            <li>
                <router-link to="/admin/theater-groups"
                    >Theater groups</router-link
                >
            </li>
        </ul>
    </nav>
    <h1 class="text-xl">Admin</h1>
    <router-view />
</template>
