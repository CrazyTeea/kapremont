<template>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-danger">Ваш браузер не удовлетворяет минимальным требованиям системы</h5>
                <h6 class="card-subtitle mb-2 text-muted">поддерживаемые браузеры</h6>
                <ul>
                    <li>Google chrome версии 80 и выше.</li>
                    <li>Opera версии 66 и выше.</li>
                    <li>Microsoft Edge chromium на windows 10.</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import platform from 'platform'
export default {
    name: "errorPage",
    mounted() {
        this.$bvModal.msgBoxOk(platform)
    }
}
</script>

<style scoped>

</style>