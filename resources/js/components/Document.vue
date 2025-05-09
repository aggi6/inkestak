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
        <button v-if="document.can_download">
            <i class="fas fa-download"></i> 
        </button>
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