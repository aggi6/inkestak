<template>
    <tr>
        <td>{{ document.id }}</td>
        <td>{{ document.name }}</td>
        <td>
        <span>
            {{ document.active ? 'Active' : 'Inactive' }}
        </span>
        </td>
        <td>
        <a v-if="document.can_download" :href="document.path" download>
            <i class="fas fa-download"></i> 
        </a>
        <span v-else>
            <i class="fas fa-ban"></i> 
        </span>
        </td>
    </tr>
</template>

<script>
    export default {
        name: 'Document',
        props: {
            document: {
                type: Object,
                required: true,
            },
        },
    };
</script>