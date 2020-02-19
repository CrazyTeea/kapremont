<template>
    <div id="program_mi_body">
        <div class="row">
            <div class="col-6">
                <h4>{{getOrg ? getOrg.name : ''}}</h4>
                <p>Субъект РФ:
                    <span class="text-success">{{getRegion ? getRegion.region: ''}}</span>
                </p>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>№</th>
                        <td>Показатель</td>
                        <td>Значение</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Объем финансового обеспечения на реализацию мероприятий по модернизации инфраструктуры, включая капитальный ремонт объектов и проведение мероприятий по антитеррористической защищенности объектов, рублей</td>
                        <td>{{getProgram ? getProgram.finance_volume : ''}}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Из них на реализацию мероприятий по антитеррористической защищенности, не более, рублей</td>
                        <td>{{getProgram? getProgram.finance_events : ''}}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Предельная стоимость капитального ремонта 1 кв. м. площади, рублей
                        </td>
                        <td>{{getProgram ? getProgram.cost : ''}}</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Ожидаемая площадь капитального ремонта, кв.м.</td>
                        <td>{{getProgram ? getProgram.value : ''}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-2">

            </div>
            <div class="col-4">
                <v-userPanel />
            </div>
        </div>
    </div>

</template>

<script>
    import {userPanel} from '../../organisms'
    import {mapActions, mapGetters} from "vuex";
    export default {
        name: "mainPage",
        computed:{
            ...mapGetters(['getProgram','getOrg','getRegion'])
        },
        methods:{
          ...mapActions(['requestProgram','requestOrg'])
        },
        components:{
            "v-userPanel":userPanel,
        },
        mounted() {
            this.requestProgram();
            this.requestOrg();
        }
    }
</script>

<style scoped>

</style>