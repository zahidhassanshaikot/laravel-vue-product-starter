<template>
    <p v-if="errors && errors?.[name]" class="error">
        <span
            v-for="(error, index) in errors[name]"
            :key="index"
            class="d-block"
            >{{ errorPlainText(error) }}</span
        >
    </p>
</template>

<script>
export default {
    props:['name', 'errors'],

    methods: {
        errorPlainText(errorMsg) {
            const msg = errorMsg
                .replace(/[0-9]/g, " ")
                .replaceAll(".", "")
            return msg;
        },
    },
};
</script>
