<template>
    <div class="table-overflow-hidden">
        <b-table-simple bordered hover>
            <b-thead>
                <b-tr>
                    <b-th>ID</b-th>
                    <b-th>Субъект</b-th>
                    <b-th>Образовательная организация высшего образования</b-th>
                    <b-th>Объектов добавлено</b-th>
                    <b-th>Выгрузка PDF</b-th>
                    <b-th>Выгрузка отправлена</b-th>
                    <b-th>Подробнее</b-th>
                </b-tr>
            </b-thead>
        </b-table-simple>
    </div>
</template>

<script>
export default {
    

}
</script>

<style>
.table-overflow-hidden {
    overflow: hidden !important;
    overflow-x: scroll !important;
}
</style>
