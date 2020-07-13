<template>
    <div>
        <b-breadcrumb v-can:root,mgsu,dep :items="
        [
             {
                text:'Список организаций',
                href:'/organization/list'
            },
            {
                text:'Список объектов',
                href:`/organization/list/${org_id}`
            },
            {
                text:this.items.name,
            },
        ]"/>
        <b-breadcrumb v-can:user :items="
        [
             {
                text:'Главная',
                href:'/'
            },
            {
                text:'Программа модернизации',
                href:`/program/view`
            },
            {
                text:this.items.name,
            },
        ]"/>
        <h1 class="mt-3">{{ this.items.name }}</h1>
        <div >
            <a v-if="canChange" :href="`/program/object/update/${this.items.id}`" class="btn btn-primary">Редактировать </a>
            <b-button v-can:root @click="tableToExel()" >Export</b-button>
            <a v-if="this.real" :href="`/program/object/set-real/${this.items.id}`" class="btn btn-success">Приступить к реализации </a>
        </div>

        <div v-if="this.items.status == 5">
            <div class="row">
                <div class="col-2">
                    <h5>Текущий статус эксперта МОН: <label :class="`text-${status.variant}`">{{ status.label }}</label></h5>
                </div>
                <div v-if="items.id_founder===1" class="col-3">
                    <h5>Текущий статус ДЭП: <label :class="`text-${dep_status.color}`">{{ dep_status.label }}</label></h5>
                </div>
                <!--<div class="col-2">
                    <h5>Текущий статус ДКУ: <label :class="`text-${dku_status.color}`">{{ dku_status.label }}</label></h5>
                </div>-->
                <div class="col-2">
                    <h5 >
                        Дата завершения текущего этапа:
                        <label>
                            {{dateStatus}}
                        </label>

                    </h5>
                </div>
                <div class="col-2" v-if="items.id_founder===1">
                    <h5 >
                        Текущий статус:
                        <label :class="`text-${realStatusType[realStatus].variant}`">
                            {{realStatusType[realStatus].label}}
                        </label>

                    </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <b-dropdown v-can:mgsu,root right text="статус эксперта МОН" size="xs"  variant="info" class="m-2" >
                        <b-dropdown-item v-if="items.id_founder ===1" @click="setStatus(2)" variant="success">Рекомендуется к согласованию</b-dropdown-item>
                        <b-dropdown-item v-if="items.id_founder ===1" @click="setStatus(3)" variant="danger">Не рекомендуется к согласованию</b-dropdown-item>
                        <b-dropdown-item v-if="items.id_founder ===1" @click="setStatus(4)" variant="warning">На доработку</b-dropdown-item>
                        <b-dropdown-item v-if="items.type || items.id_founder !==1" @click="setStatus(5)" variant="info">В реализации</b-dropdown-item>
                    </b-dropdown>
                </div>
                <div v-if="items.id_founder===1" class="col-4">
                    <b-dropdown v-can:dep,root right text="статус ДЭП" variant="info" class="m-2">
                        <b-dropdown-item :href="`/api/set-status/approved/dep/${obj_id}`" @click="actionHendler" variant="success">Рассмотрено ДЭП</b-dropdown-item>
                        <b-dropdown-item :href="`/api/set-status/rejected/dep/${obj_id}`" @click="actionHendler" variant="warning">Резерв</b-dropdown-item>
                    </b-dropdown>
                </div>
                <!--<div class="col-3">
                    <b-dropdown v-can:dku,root right  text="статус ДКУ" variant="info" class="m-2">
                        <b-dropdown-item :href="`/api/set-status/approved/dku/${obj_id}`" @click="actionHendler" variant="success">Рассмотрено ДКУ</b-dropdown-item>
                        <b-dropdown-item :href="`/api/set-status/rejected/dku/${obj_id}`" @click="actionHendler" variant="warning">Резерв</b-dropdown-item>
                    </b-dropdown>
                </div>-->
                <div v-if="items.id_founder===1" class="col-4">
                    <b-dropdown v-can:root,dep right class="m-2" :text="realStatusType[realStatus].label" :variant="realStatusType[realStatus].variant">
                        <b-dropdown-item v-for="(item,index) in realStatusType" @click="changeRealStatus(index)"
                                         :key="index" :variant="item.variant" :value="index">{{item.label}}</b-dropdown-item>
                    </b-dropdown>
                </div>
            </div>

            <label for="object_opis">Краткое описание планируемых работ по объекту</label>
            <b-form-input @input="ObjectOpis" id="object_opis" v-can:user,root,faiv_user v-model="items.object_opis" />
            <span v-can:root,mgsu>{{items.object_opis}}</span>
        </div>

        <div v-else>
            <div class="row">
                <div class="col-6">
                    <h5>Текущий статус эксперта МОН: <label :class="`text-${status.variant}`">{{ status.label }}</label></h5>
                </div>
                <div v-if="items.id_founder===1" class="col-6">
                    <h5>Текущий статус ДЭП: <label :class="`text-${dep_status.color}`">{{ dep_status.label }}</label></h5>
                </div>
                <!--<div class="col-4">
                    <h5>Текущий статус ДКУ: <label :class="`text-${dku_status.color}`">{{ dku_status.label }}</label></h5>
                </div>-->
            </div>
            <div class="row">
                <div class="col-2">
                    <b-dropdown v-can:mgsu,root right text="статус эксперта МОН"  variant="info" class="m-2" >
                        <b-dropdown-item v-if="items.id_founder ===1" @click="setStatus(2)" variant="success">Рекомендуется к согласованию</b-dropdown-item>
                        <b-dropdown-item v-if="items.id_founder ===1" @click="setStatus(3)" variant="danger">Не рекомендуется к согласованию</b-dropdown-item>
                        <b-dropdown-item v-if="items.id_founder ===1" @click="setStatus(4)" variant="warning">На доработку</b-dropdown-item>
                        <b-dropdown-item v-if="items.type || items.id_founder !==1" @click="setStatus(5)" variant="info">В реализации</b-dropdown-item>
                    </b-dropdown>
                </div>
                <div v-if="items.id_founder===1" class="col-4">
                    <b-dropdown v-can:dep,root right text="статус ДЭП" variant="info" class="m-2">
                        <b-dropdown-item :href="`/api/set-status/approved/dep/${obj_id}`" @click="actionHendler" variant="success">Рассмотрено ДЭП</b-dropdown-item>
                        <b-dropdown-item :href="`/api/set-status/rejected/dep/${obj_id}`" @click="actionHendler" variant="warning">Резерв</b-dropdown-item>
                    </b-dropdown>
                </div>
                <!--<div class="col-4">
                    <b-dropdown v-can:dku,root right  text="статус ДКУ" variant="info" class="m-2">
                        <b-dropdown-item :href="`/api/set-status/approved/dku/${obj_id}`" @click="actionHendler" variant="success">Рассмотрено ДКУ</b-dropdown-item>
                        <b-dropdown-item :href="`/api/set-status/rejected/dku/${obj_id}`" @click="actionHendler" variant="warning">Резерв</b-dropdown-item>
                    </b-dropdown>
                </div>-->
            </div>
            <v-comments :obj_id="obj_id" />
        </div>



        <div class="mt-3">
            <div class="row">
                <div class="col-12">
                    <b-alert v-for="(banner, index) in bannerInfo" :key="index" :show="banner.show" :variant="banner.variant" dismissible fade>{{ banner.message }}</b-alert>
                </div>
            </div>
        </div>
        <b-table-simple bordered hover class="mt-3">
            <b-tbody>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>ID</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.id }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>ID организации</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ org_id }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Наименование организации</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.org_name }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Наименование</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.name }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Полный адрес объекта</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.address }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Назначение</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.assignment }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Общая площадь здания - всего, кв.м.</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.square }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Год постройки здания</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.year }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Износ</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ getIznos(this.items.wear) }}</label>
                    </b-th>
                </b-tr>
                <b-tr>
                    <b-th class="center-text-in-cell">
                        <label>Примечание</label>
                    </b-th>
                    <b-th class="normal-font-weight-for-sell center-text-in-cell">
                        <label>{{ this.items.note }}</label>
                    </b-th>
                </b-tr>
            </b-tbody>
        </b-table-simple>



        <div v-if="this.items.status == 5">
            <v-comments :obj_id="obj_id" />
            <b-card no-body class="mb-1 mt-2">
                <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-s>
                                <b-icon-gear-wide-connected />
                                Согласованный график мероприятий
                            </span>
                </b-card-header>
                <b-collapse id="accordion-s" accordion="my-accordion2" role="tabpanel" visible>
                    <b-card-body style="overflow: auto">
                        <div class="wraper-for-chart" style="overflow-x: scroll">
                            <div class="chart-wrapper">
                                <div class="charter1"></div>
                                <div class="charter2"></div>
                                <ul class="labels-for-chart">
                                    <li>Проведение тендера и заключение договора на выполнение обследования</li>
                                    <li>Выполнение обследования, подготовка и утверждение дефектного акта (дефектной ведомости)</li>
                                    <li>Утверждение задания на проектирование</li>
                                    <li>Проведение тендера и заключение договора на подготовку проектно-сметной документации</li>
                                    <li>Подготовка проектно-сметной документации</li>
                                    <li>Прохождение экспертизы проектно-сметной документации</li>
                                    <li>Проведение тендера и заключение договора на выполнение строительно-монтажных работ</li>
                                    <li>Выполнение строительно-монтажных работ</li>
                                </ul>
                                <ul class="chart-values">
                                    <li>январь</li>
                                    <li>февраль</li>
                                    <li>март</li>
                                    <li>апрель</li>
                                    <li>май</li>
                                    <li>июнь</li>
                                    <li>июль</li>
                                    <li>август</li>
                                    <li>сентябрь</li>
                                    <li>октябрь</li>
                                    <li>ноябрь</li>
                                    <li>декабрь</li>
                                </ul>
                                <ul class="chart-bars">
                                    <li data-duration="январь-февраль½" data-color="#b03532"></li>
                                    <li data-duration="февраль-июнь" data-color="#33a8a5"></li>
                                    <li data-duration="июнь-июль½" data-color="#30997a"></li>
                                    <li data-duration="июль½-август" data-color="#6a478f"></li>
                                    <li data-duration="август-октябрь" data-color="#da6f2b"></li>
                                    <li data-duration="октябрь-ноябрь" data-color="#3d8bb1"></li>
                                    <li data-duration="октябрь-декабрь½" data-color="#e03f3f"></li>
                                    <li data-duration="декабрь½-декабрь" data-color="#59a627"></li>
                                </ul>
                            </div>
                        </div>

                    </b-card-body>
                </b-collapse>
            </b-card>
            <b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-real>
                                <b-icon-gear-wide-connected />
                                Реализация мероприятий</span
                            >
                </b-card-header>
                <b-collapse id="accordion-real" accordion="my-accordion2" role="tabpanel">
                    <b-card-body>
                        <b-table-simple bordered small >
                            <b-thead>
                                <b-th>Показатель</b-th>
                                <b-th>Значение</b-th>
                            </b-thead>
                            <b-tbody>
                                <b-tr>
                                    <b-td>Утвержденное бюджетное финансирование работ по объекту</b-td>
                                    <b-td>{{parseFloat(fromServer.program.finance_volume)}}</b-td>
                                </b-tr>
                                <b-tr>
                                    <b-td>Сумма освоенных бюджетных средств</b-td>
                                    <b-td>{{s_bud_f}}</b-td>
                                </b-tr>
                                <b-tr>
                                    <b-td>Экономия бюджетных средств по объекту</b-td>
                                    <b-td>{{parseFloat(fromServer.program.finance_volume)-s_bud_f}}</b-td>
                                </b-tr>
                            </b-tbody>
                        </b-table-simple>
                    </b-card-body>
                </b-collapse>
            </b-card>
            <!--<b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-plan>
                                <b-icon-gear-wide-connected />
                                План-график мероприятий</span
                            >
                </b-card-header>
                <b-collapse id="accordion-plan" accordion="my-accordion2" role="tabpanel">
                    <b-card-body>
                        <b-table-simple class="mt-3" small sticky-header bordered style="min-height: 1000px">
                            <b-thead>
                                <b-tr>
                                    <b-th></b-th>
                                    <b-th>Этап</b-th>
                                    <b-th>Дата начала (план.)</b-th>
                                    <b-th>Дата окончания (план.)</b-th>
                                    <b-th>Фактическая Стоимость реализации (тыс.руб.)</b-th>
                                    <b-th>Фактическая Сумма бюджетного финансирования на проведение капитального ремонта (тыс. руб.)</b-th>
                                    <b-th>Фактическое Софинансирование из внебюджетных источников (тыс. руб.)</b-th>
                                    <b-th>Отметка о завершении этапа </b-th>

                                    <b-th>Подтверждающие документы</b-th>

                                    <b-th>Комментарий (текстовое поле Заполняет ВУЗ)</b-th>
                                    <b-th>Отметка Эксперта МОН Принято / не принято</b-th>
                                    <b-th>Комментарий эксперта МОН )</b-th>
                                </b-tr>
                            </b-thead>
                            <b-tbody>
                                <b-tr  v-for="(item,index) in svedenia2" :key="index" @change="sendData(item)">
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        {{item.step + 1}}
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input v-can:user,root,faiv_user v-if="item.canDelete" v-model="svedenia2[index].step_name" />
                                        <span v-else>{{item.step_name}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input v-can:user,root,faiv_user type="date" v-model="svedenia2[index].date_event_start" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.date_event_start}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input v-can:user,root,faiv_user type="date" v-model="svedenia2[index].date_event_end" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.date_event_end}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input v-can:user,root,faiv_user type="number" step=".01"  v-model="svedenia2[index].cost_real" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.cost_real}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input v-can:user,root,faiv_user type="number" step=".01"  v-model="svedenia2[index].sum_bud_fin" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.sum_bud_fin}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input v-can:user,root,faiv_user type="number" step=".01"  v-model="svedenia2[index].fin_vnebud_ist" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.fin_vnebud_ist}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-checkbox v-can:user,root,faiv_user v-model="svedenia2[index].done" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.done ? 'Да' : 'Нет'}}</span>
                                    </b-td>


                                    &lt;!&ndash; Подтверждающие документы &ndash;&gt;
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        &lt;!&ndash; <label @click="debugItem(item, svedenia2[index], index)"> Debug item {{index}} </label> &ndash;&gt;
                                        {{item.help}}
                                        <b-form-input
                                                v-can:user,root,faiv_user
                                                placeholder="Ссылка на zakupki.gov.ru"
                                                v-if=" sved2Href.includes(item.step + 1)"
                                                v-model="svedenia2[index].access_document"
                                        />

                                        <div v-can:user,root,faiv_user v-if="sved2Doc.includes(item.step + 1)" class="fileInput">
                                            <div
                                                    class="cell-center-for-items"

                                            >
                                                <input
                                                        type="file"
                                                        :id="'file_input_' + index"
                                                        class="hidden-file-input"
                                                        @change="fileInput(index)"
                                                />
                                                <div
                                                        class="arrow">
                                                    <label
                                                            :for="`file_input_${index}`"
                                                            class="label"
                                                    >
                                                            <span class="title">
                                                                <span class="scope-to-animate"></span>
                                                                <span class="scope-to-animate"></span>
                                                                <span class="scope-to-animate"></span>
                                                                <span class="scope-to-animate"></span>
                                                            </span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <div v-if="svedenia2[index].file">
                                            <a :href="`/program/event/download/${item.id}`">{{svedenia2[index].file.name}}</a>
                                        </div>
                                        <a v-if="svedenia2[index].access_document && svedenia2[index].access_document != 'null'"
                                           :href=svedenia2[index].access_document v-can:mgsu,dep,dku,dku_user>{{svedenia2[index].access_document}}</a>


                                    </b-td>


                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input v-can:user,root,faiv_user,faiv_user v-model="svedenia2[index].comment" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.comment}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-checkbox v-can:root,mgsu,dep v-model="svedenia2[index].doneExpert" />
                                        <span v-can:user>
                                            {{item.doneExpert ? 'Да' : 'Нет'}}
                                        </span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input v-can:root,mgsu,dep v-model="svedenia2[index].commentExpert" />
                                        <span v-can:user>
                                            {{item.commentExpert}}
                                        </span>
                                    </b-td>
                                    <div v-can:user,root,faiv_user v-else>
                                        <b-td>
                                            <b-button variant="danger" @click="deleteRow(index)">Удалить</b-button>
                                        </b-td>
                                        <b-td >
                                            <b-button variant="info" @click="addRow(index)">Добавить</b-button>
                                        </b-td>
                                    </div>

                                </b-tr>

                            </b-tbody>

                        </b-table-simple>
                        <b-table-simple style="display:none" id="exportPlan" class="mt-3" small sticky-header bordered>
                            <b-thead>
                                <b-tr>
                                    <b-th></b-th>
                                    <b-th>Этап</b-th>
                                    <b-th>Дата начала (план.)</b-th>
                                    <b-th>Дата окончания (план.)</b-th>
                                    <b-th>Фактическая Стоимость реализации (тыс.руб.)</b-th>
                                    <b-th>Фактическая Сумма бюджетного финансирования на проведение капитального ремонта (тыс. руб.)</b-th>
                                    <b-th>Фактическое Софинансирование из внебюджетных источников (тыс. руб.)</b-th>
                                    <b-th>Отметка о завершении этапа </b-th>
                                    <b-th>Подтверждающие документы</b-th>
                                    <b-th>Комментарий (текстовое поле Заполняет ВУЗ)</b-th>
                                    <b-th>Отметка Эксперта МОН Принято / не принято</b-th>
                                    <b-th>Комментарий эксперта МОН )</b-th>
                                </b-tr>
                            </b-thead>
                            <b-tbody>
                                <b-tr  v-for="(item,index) in svedenia2" :key="index" @change="sendData(item)" v-if="!(item.hasOwnProperty('button') && item.button)">
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        {{item.step + 1}}
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <span v-can:user,root,faiv_user>{{item.step_name}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <span v-can:user,root,faiv_user>{{item.date_event_start}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <span v-can:user,root,faiv_user>{{item.date_event_end}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <span v-can:user,root,faiv_user>{{item.cost_real}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <span  v-can:user,root,faiv_user>{{item.sum_bud_fin}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <span v-can:user,root,faiv_user>{{item.fin_vnebud_ist}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <span v-can:user,root,faiv_user>{{item.done ? 'Да' : 'Нет'}}</span>
                                    </b-td>
                                    &lt;!&ndash; Подтверждающие документы &ndash;&gt;
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        &lt;!&ndash; <label @click="debugItem(item, svedenia2[index], index)"> Debug item {{index}} </label> &ndash;&gt;
                                        {{item.help}}
                                        <span v-can:user,root,faiv_user >{{svedenia2[index].access_document}}</span>
                                        <div v-if="svedenia2[index].file">
                                            {{svedenia2[index].file.name}}
                                        </div>


                                    </b-td>


                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <span v-can:user,root,faiv_user>{{item.comment}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <span v-can:root,mgsu,dep>
                                            {{item.doneExpert ? 'Да' : 'Нет'}}
                                        </span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <span v-can:root,user>
                                            {{item.commentExpert}}
                                        </span>
                                    </b-td>

                                </b-tr>

                            </b-tbody>

                        </b-table-simple>
                    </b-card-body>
                </b-collapse>
            </b-card>-->
            <b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-plan2>
                                <b-icon-gear-wide-connected />
                                План-график мероприятий
                            </span>
                </b-card-header>
                <b-collapse id="accordion-plan2" accordion="my-accordion2" role="tabpanel">
                    <b-card-body>
                        <b-table-simple class="mt-3" small sticky-header bordered style=" font-size: 10px; min-height: 1000px">
                            <b-thead>
                                <b-tr>
                                    <b-th></b-th>
                                    <b-th>Этап</b-th>
                                    <b-th style="min-width: 65px">Дата начала</b-th>
                                    <b-th style="min-width: 65px">Дата окончания</b-th>
                                    <b-th style="min-width: 65px">Общая Фактическая
                                        Стоимость реализации
                                        (тыс.руб.)
                                    </b-th >
                                    <b-th>Фактическая <br> Сумма <br> бюджетного финансирования
                                        (тыс. руб.)
                                    </b-th>
                                    <b-th style="max-width: 80px">Софинанси-рование  (тыс. руб.)</b-th>
                                    <b-th style="max-width: 80px">Отметка о завершении этапа </b-th>

                                    <b-th>Подтверждающие <br> документы</b-th>

                                    <b-th>Комментарий (текстовое поле Заполняет ВУЗ)</b-th>
                                    <b-th>Эксперт<br>МОН +/-
                                    </b-th>
                                   <b-th>Комментарий эксперта МОН )</b-th>
                                </b-tr>
                            </b-thead>
                            <b-tbody>
                                <b-tr  v-for="(item,index) in svedenia2" :key="index" @change="sendData(item)" :variant="!isFloat(item.step) ? 'success' : ''">
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        {{getMonth(item.step)}}
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input style="font-size: 10px"  v-can:user,faiv_user,root v-if="item.canDelete && item.step < 7" v-model="svedenia2[index].step_name" />
                                        <span v-else>{{item.step_name}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input style="font-size: 10px"  v-can:user,faiv_user,root type="date" v-model="svedenia2[index].date_event_start" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.date_event_start}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input style="font-size: 10px"  v-can:user,faiv_user,root type="date" v-model="svedenia2[index].date_event_end" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.date_event_end}}</span>
                                    </b-td>
                                    <b-td style="max-width: 10px" v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input style="font-size: 10px"  v-can:user,faiv_user,root type="number" step=".01"  v-model="svedenia2[index].cost_real" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.cost_real}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input style="font-size: 10px"  v-can:user,faiv_user,root type="number" step=".01"  v-model="svedenia2[index].sum_bud_fin" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.sum_bud_fin}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input style="font-size: 10px"  v-can:user,faiv_user,root type="number" step=".01"  v-model="svedenia2[index].fin_vnebud_ist" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.fin_vnebud_ist}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-checkbox style="font-size: 10px"  v-can:user,faiv_user,root v-model="svedenia2[index].done" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.done ? 'Да' : 'Нет'}}</span>
                                    </b-td>


                                    <!-- Подтверждающие документы -->
                                    <b-td style="max-width: 50px" v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <!-- <label @click="debugItem(item, svedenia2[index], index)"> Debug item {{index}} </label> -->
                                        {{item.help}}
                                        <b-form-input
                                                v-can:user,root,faiv_user
                                                placeholder="Ссылка на zakupki.gov.ru"
                                                v-if=" sved2Href.includes(item.step + 1)"
                                                v-model="svedenia2[index].access_document"
                                        />

                                        <div v-can:user,faiv_user,root v-if="sved2Doc.includes(item.step + 1)" class="fileInput">
                                            <div
                                                    class="cell-center-for-items"

                                            >
                                                <input
                                                        type="file"
                                                        :id="'file_input_' + index"
                                                        class="hidden-file-input"
                                                        @change="fileInput(index)"
                                                />
                                                <div
                                                        class="arrow">
                                                    <label
                                                            :for="`file_input_${index}`"
                                                            class="label"
                                                    >
                                                            <span class="title">
                                                                <span class="scope-to-animate"></span>
                                                                <span class="scope-to-animate"></span>
                                                                <span class="scope-to-animate"></span>
                                                                <span class="scope-to-animate"></span>
                                                            </span>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <div v-if="svedenia2[index].file">
                                            <a :href="`/program/event/download/${item.id}`">{{svedenia2[index].file.name}}</a>
                                        </div>
                                        <a v-if="svedenia2[index].access_document && svedenia2[index].access_document != 'null'"
                                           :href=svedenia2[index].access_document v-can:mgsu,dep,dku,dku_user>{{svedenia2[index].access_document}}</a>


                                    </b-td>


                                    <b-td style="max-width: 100px" v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-input style="font-size: 10px"  v-can:user,root,faiv_user v-model="svedenia2[index].comment" />
                                        <span v-can:mgsu,dep,dku,dku_user>{{item.comment}}</span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-checkbox style="font-size: 10px"  v-can:root,mgsu,dep v-model="svedenia2[index].doneExpert" />
                                        <span v-can:user>
                                            {{item.doneExpert ? 'Да' : 'Нет'}}
                                        </span>
                                    </b-td>
                                    <b-td v-if="!(item.hasOwnProperty('button') && item.button)">
                                        <b-form-textarea style="font-size: 10px"  aria-invalid="true" size="sm" type="area" v-can:root,mgsu,dep v-model="svedenia2[index].commentExpert" />
                                        <span v-can:user>
                                            {{item.commentExpert}}
                                        </span>
                                    </b-td>
                                    <div v-can:user,faiv_user,root v-else>
                                        <b-td>
                                            <b-button size="sm" variant="danger" @click="deleteRow(index)">Удалить</b-button>
                                            <b-button size="sm" variant="info" @click="addRow(index)">Добавить</b-button>
                                        </b-td>
                                    </div>

                                </b-tr>

                            </b-tbody>

                        </b-table-simple>
                    </b-card-body>
                </b-collapse>
            </b-card>
            <b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-archive>
                                <b-icon-gear-wide-connected />
                                Архив
                            </span>
                </b-card-header>
                <b-collapse id="accordion-archive" accordion="my-accordion2" role="tabpanel">
                    <b-card-body>
                        <b-card no-body class="mb-1">
                            <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-2a>
                                <b-icon-gear-wide-connected />
                                Сведения о планируемых мероприятиях</span
                            >
                            </b-card-header>
                            <b-collapse id="accordion-2a" accordion="my-accordion" role="tabpanel">
                                <b-card-body>
                                    <b-table bordered :fields="svedenia.fields" :items="svedenia.items" />
                                </b-card-body>
                            </b-collapse>
                        </b-card>
                        <b-card v-if="checkFOIV()" no-body class="mb-1">
                            <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-3a>
                                <b-icon-gear-wide-connected />
                                Обоснование необходимости (целесообразности) планируемых мероприятий</span
                            >
                            </b-card-header>
                            <b-collapse id="accordion-3a" accordion="my-accordion" role="tabpanel">
                                <b-card-body>
                                    <b-table bordered :fields="necessary.fields.one" :items="necessary.items.one" />
                                    <b-table bordered :fields="necessary.fields.two" :items="necessary.items.two" />
                                </b-card-body>
                            </b-collapse>
                        </b-card>
                        <b-card v-if="checkFOIV()" no-body class="mb-1">
                            <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-4a>
                                <b-icon-gear-wide-connected />
                                Ожидаемые результаты</span
                            >
                            </b-card-header>
                            <b-collapse id="accordion-4a" accordion="my-accordion" role="tabpanel">
                                <b-card-body>
                                    <b-table bordered :fields="waited.fields" :items="waited.items" />
                                </b-card-body>
                            </b-collapse>
                        </b-card>
                        <b-card v-if="checkFOIV()" no-body class="mb-1">
                            <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-5a>
                                <b-icon-gear-wide-connected />
                                Прогнозируемые риски</span
                            >
                            </b-card-header>
                            <b-collapse id="accordion-5a" accordion="my-accordion" role="tabpanel">
                                <b-card-body>
                                    <b-table bordered :fields="risks.fields" :items="risks.items" />
                                </b-card-body>
                            </b-collapse>
                        </b-card>
                        <b-card v-if="checkFOIV()" no-body class="mb-1">
                            <b-card-header header-tag="header" class="p-1" role="tab">
                                <span> <b-icon icon="document-text" scale="1.5" class="mr-2 ml-1"></b-icon>Загруженные документы</span>
                            </b-card-header>
                            <b-card-body>
                                <div  v-if="docs.length">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Наименование</th>
                                            <th>Файл</th>
                                        </tr>
                                        </thead>

                                        <tr v-for="(doc, index) in docs" :key="index">
                                            <td>{{doc.label}}</td>
                                            <td><a :href="`/program/object/download-doc/${obj_id}?id=${doc.id}`">{{doc.name }}.pdf</a></td>
                                        </tr>
                                    </table>
                                    <a class="btn btn-danger" target="_blank" :href="`/program/object/zip/${obj_id}`">Скачать архивом</a>
                                </div>
                                <div v-else>
                                    <label>Документы отсутствуют</label>
                                </div>
                            </b-card-body>
                        </b-card>
                    </b-card-body>
                </b-collapse>
            </b-card>
        </div>
        <div v-else>
            <b-card no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-2b>
                                <b-icon-gear-wide-connected />
                                Сведения о планируемых мероприятиях</span
                            >
                </b-card-header>
                <b-collapse id="accordion-2b" accordion="my-accordion" role="tabpanel">
                    <b-card-body>
                        <b-table bordered :fields="svedenia.fields" :items="svedenia.items" />
                    </b-card-body>
                </b-collapse>
            </b-card>
            <b-card v-if="checkFOIV()" no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-3b>
                                <b-icon-gear-wide-connected />
                                Обоснование необходимости (целесообразности) планируемых мероприятий</span
                            >
                </b-card-header>
                <b-collapse id="accordion-3b" accordion="my-accordion" role="tabpanel" >
                    <b-card-body>
                        <b-table bordered :fields="necessary.fields.one" :items="necessary.items.one" />
                        <b-table bordered :fields="necessary.fields.two" :items="necessary.items.two" />
                    </b-card-body>
                </b-collapse>
            </b-card>
            <b-card v-if="checkFOIV()" no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-4b>
                                <b-icon-gear-wide-connected />
                                Ожидаемые результаты</span
                            >
                </b-card-header>
                <b-collapse id="accordion-4b" accordion="my-accordion" role="tabpanel">
                    <b-card-body>
                        <b-table bordered :fields="waited.fields" :items="waited.items" />
                    </b-card-body>
                </b-collapse>
            </b-card>
            <b-card v-if="checkFOIV()" no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                            <span class="toggle_button" v-b-toggle.accordion-5b>
                                <b-icon-gear-wide-connected />
                                Прогнозируемые риски</span
                            >
                </b-card-header>
                <b-collapse id="accordion-5b" accordion="my-accordion" role="tabpanel">
                    <b-card-body>
                        <b-table bordered :fields="risks.fields" :items="risks.items" />
                    </b-card-body>
                </b-collapse>
            </b-card>
            <b-card v-if="checkFOIV()" no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                    <span> <b-icon icon="document-text" scale="1.5" class="mr-2 ml-1"></b-icon>Загруженные документы</span>
                </b-card-header>
                <b-card-body>
                    <div  v-if="docs.length">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Наименование</th>
                                <th>Файл</th>
                            </tr>
                            </thead>

                            <tr v-for="(doc, index) in docs" :key="index">
                                <td>{{doc.label}}</td>
                                <td><a :href="`/program/object/download-doc/${obj_id}?id=${doc.id}`">{{doc.name }}.pdf</a></td>
                            </tr>
                        </table>
                        <a class="btn btn-danger" target="_blank" :href="`/program/object/zip/${obj_id}`">Скачать архивом</a>
                    </div>
                    <div v-else>
                        <label>Документы отсутствуют</label>
                    </div>
                </b-card-body>
            </b-card>
        </div>


    </div>
</template>

<script>
    import Axios from "axios";
    import {CommentComponent} from "../../../organisms";
    import {mapActions, mapGetters} from "vuex";
    import {
        BAlert,
        BBreadcrumb,
        BButton,
        BCard,
        BCardBody,
        BCardHeader,
        BCollapse,
        BDropdown,
        BDropdownItem,
        BFormCheckbox,
        BFormTextarea,
        BFormFile,
        BFormInput,
        BTable,
        BTableSimple,
        BTbody,
        BTd,
        BTh,
        BThead,
        BTr,
        VBToggle,
    } from 'bootstrap-vue'

    export default {
        directives:{
            'b-toggle':VBToggle
        },
        components: {
            "v-comments": CommentComponent,
            BFormFile,
            BAlert,
            BBreadcrumb,
            BCollapse,
            BTableSimple,
            BTr,
            BTh,
            BThead,
            BTbody,
            BDropdown,
            BDropdownItem,
            BTable,
            BCard,
            BFormTextarea,
            BButton,
            BCardHeader,
            BFormCheckbox,
            BCardBody,
            BTd,
            BFormInput
        },
        data() {
            return {
                bannerInfo: [],
                canChange: false,
                dateStatus:'',
                status: {
                    label: '',
                    variant: ''
                },
                permission:window.Permission,
                realStatus:0,
                curMonth:0,
                months: [
                    'январь',
                    'февраль',
                    'март',
                    'апрель',
                    'май',
                    'июнь',
                    'июль',
                    'август',
                    'сентябрь',
                    'октябрь',
                    'ноябрь',
                    'декабрь'
                ],
                realStatusType:[
                    {
                        variant:'secondary',
                        label:'Серый'
                    },
                    {
                        variant:'warning',
                        label:'Желтый'
                    },
                    {
                        variant:'success',
                        label:'Зеленый'
                    },
                    {
                        variant:'danger',
                        label:'Красный'
                    },
                ],
                dep_status: {
                    label: null,
                    color: null
                },
                dku_status: {
                    label: null,
                    color: null
                },
                show: {
                    dep: false,
                    dku: false
                },
                csrf: document.getElementsByName("csrf-token")[0].content,
                items: [],
                real:false,
                obj_id: null,
                org_id: null,
                docs: [],
                fromServer:{},
                s_bud_f:0,
                r_bud_f:0,

                svedenia2:[
                    {
                        canDelete:false,
                        step:0,
                        id_event:null,
                        step_name:'Проведение тендера и заключение договора на выполнение обследования',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        access_document:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        file:null,
                        comment:'',
                        commentExpert:'',
                        parent:true
                    },
                    {
                        canDelete:false,
                        step:0.1,
                        id_event:null,
                        step_name:'Внесение пользователем закупки на обследование объекта в план закупок ',
                        help:'Сканированный план закупок пользователя',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        file:null,
                        sum_bud_fin:null,
                        access_document:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        canDelete:false,
                        step:0.2,
                        id_event:null,
                        step_name:'Объявление пользователем аукциона на обследование объекта',
                        date_event_start: null,
                        access_document:null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        file:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        canDelete:false,
                        step:0.3,
                        id_event:null,
                        step_name:'Определение подрядчика по результату аукциона',
                        help: 'Протокол результатов проведения аукциона ',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        access_document:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        file:null,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        canDelete:false,
                        step:0.4,
                        id_event:null,
                        step_name:'Заключение договора с подрядчиком',
                        help: 'Сканированный договор с подрядчиком',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        access_document:null,
                        file:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        step:0.99999999,
                        canDelete:false,
                        button:true,
                        button_name:'Добавить'
                    },
                    {
                        canDelete:false,
                        step:1,
                        id_event:null,
                        step_name:'Выполнение обследования, подготовка и утверждение дефектного акта (дефектной ведомости). ',
                        help: 'Отчет об обследовании, дефектный акт',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        access_document:null,
                        file:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:true
                    },
                    {
                        step:1.9999999,
                        canDelete:false,
                        button:true,
                        button_name:'Добавить'
                    },
                    {
                        canDelete:false,
                        step:2,
                        id_event:null,
                        file:null,
                        step_name:'Утверждение задания на проектирование ',
                        help: 'Сканированное задание на проектирование',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        access_document:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:true
                    },
                    {
                        step:2.9999999,
                        canDelete:false,
                        button:true,
                        button_name:'Добавить'
                    },
                    {
                        canDelete:false,
                        step:3,
                        id_event:null,
                        step_name:'Проведение тендера и заключение договора на подготовку проектно-сметной документации.',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        file:null,
                        access_document:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:true
                    },
                    {
                        canDelete:false,
                        step:3.1,
                        id_event:null,
                        step_name:'Внесение пользователем закупки на ПСД',
                        help: 'Сканированный план закупок пользователя',
                        date_event_start: null,
                        date_event_end: null,
                        access_document:null,
                        file:null,
                        cost_real:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        canDelete:false,
                        step:3.2,
                        id_event:null,
                        step_name:'Объявление пользователем аукциона на ПСД',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        file:null,
                        sum_bud_fin:null,
                        access_document:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        canDelete:false,
                        step:3.3,
                        id_event:null,
                        step_name:'Определение подрядчика по результату аукциона',
                        help: 'Протокол результатов проведения аукциона ',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        access_document:null,
                        file:null,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        canDelete:false,
                        step:3.4,
                        id_event:null,
                        step_name:'Заключение договора с подрядчиком',
                        help: 'Сканированный договор с подрядчиком',
                        date_event_start: null,
                        date_event_end: null,
                        access_document:null,
                        cost_real:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        file:null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        step:3.999999,
                        canDelete:false,
                        button:true,
                        button_name:'Добавить'
                    },
                    {
                        canDelete:false,
                        step:4,
                        id_event:null,
                        step_name:'Подготовка проектно-сметной документации.',
                        help: 'Сканированный акт сдачи-приемки выполненных проектных работ. Проектно-сметная документация',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        access_document:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        file:null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:true
                    },
                    {
                        step:4.99999999999,
                        canDelete:false,
                        button:true,
                        button_name:'Добавить'
                    },
                    {
                        canDelete:false,
                        step:5,
                        id_event:null,
                        step_name:'Прохождение экспертизы проектно-сметной документации.',
                        help: 'Заключение экспертизы',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        access_document:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        file:null,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:true
                    },
                    {
                        step:5.999999999,
                        canDelete:false,
                        button:true,
                        button_name:'Добавить'
                    },
                    {
                        canDelete:false,
                        step:6,
                        id_event:null,
                        step_name:'Проведение тендера и заключение договора на выполнение строительно-монтажных работ.',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        access_document:null,
                        is_nessesary: null,
                        done:false,
                        file:null,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:true
                    },
                    {
                        canDelete:false,
                        step:6.1,
                        id_event:null,
                        step_name:'Внесение пользователем закупки на выполнение СМР в план закупок.',
                        help: 'Сканированный план закупок пользователя',
                        date_event_start: null,
                        date_event_end: null,
                        access_document:null,
                        file:null,
                        cost_real:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        canDelete:false,
                        step:6.2,
                        id_event:null,
                        step_name:'Объявление аукциона на СМР',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        file:null,
                        sum_bud_fin:null,
                        access_document:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        canDelete:false,
                        step:6.3,
                        id_event:null,
                        step_name:'Определение подрядчика по результату аукциона',
                        help: 'Протокол результатов проведения аукциона ',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        done:false,
                        access_document:null,
                        file:null,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        canDelete:false,
                        step:6.4,
                        id_event:null,
                        step_name:'Заключение договора с подрядчиком',
                        help: 'Сканированный договор с подрядчиком',
                        date_event_start: null,
                        date_event_end: null,
                        access_document:null,
                        cost_real:null,
                        sum_bud_fin:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        file:null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:false
                    },
                    {
                        step:6.999999,
                        canDelete:false,
                        button:true,
                        button_name:'Добавить'
                    },
                    {
                        canDelete:false,
                        step:7,
                        id_event:null,
                        step_name:'Выполнение строительно-монтажных работ.',
                        help: 'Акт сдачи-приемки выполненных СМР. ',
                        date_event_start: null,
                        date_event_end: null,
                        cost_real:null,
                        sum_bud_fin:null,
                        access_document:null,
                        fin_vnebud_ist:null,
                        is_nessesary: null,
                        file:null,
                        done:false,
                        doneExpert:false,
                        comment:'',
                        commentExpert:'',
                        parent:true
                    },
                    {
                        step:7.999999,
                        canDelete:false,
                        button:true,
                        button_name:'Добавить'
                    }


                ],
                svedenia: {
                    labels: [
                        'Проведение тендера и заключение договора на выполнение обследования',
                        'Выполнение обследования, подготовка и утверждение дефектного акта',
                        'Утверждение задания на проектирование',
                        'Проведение тендера и заключение договора на подготовку проектно-сметной документации',
                        'Подготовка проектно-сметной документации',
                        'Прохождение экспертизы проектно-сметной документации',
                        'Проведение тендера и заключение договора на выполнение строительно-монтажных работ',
                        'Выполнение строительно-монтажных работ'
                    ],
                    items:[],
                    fields:[
                        {key:'index',label:'№'},
                        {key:'step',label:'Этап'},
                        {key:'is_nessesary',label:'Необходимость выполнения'},
                        {key:'date_event_start',label:'Дата начала'},
                        {key:'date_event_end',label:'Дата окончания'},
                        {key:'cost_real',label:'Стоимость реализации (тыс.руб)'},
                        {key:'sum_bud_fin',label:'Сумма бюджетного финансирования на проведение кап.ремонта (тыс.руб)'},
                        {key:'fin_vnebud_ist',label:'Софинансирование из внебюджетных источников (тыс.руб)'},
                    ]
                },
                necessary: {
                    labels:[
                        'Фундаменты',
                        'Отмостка',
                        'Стены ',
                        'Колонны',
                        'Перегородки',
                        'Крыша (покрытия)',
                        'Кровля',
                        'Перекрытия',
                        'Полы',
                        'Окна',
                        'Двери',
                        'Ворота',
                        'Лестницы',
                        'Крыльца',
                        'Балконы/лоджии',
                        'Внутренняя отделка',
                        'Наружная отделка',
                        'Система электроснабжения',
                        'Система водоснабжения',
                        'Система водоотведения',
                        'Система газоснабжения',
                        'Система кондиционирования воздуха',
                        'Система вентиляции',
                        'Система отопления',
                        'Система диспетчеризации',
                        'Радиофикация',
                        'Телевидение эфирное',
                        'Система видеонаблюдения',
                        'Система интернет и телефонии',
                        'Система контроля управления доступом',
                        'Пожарная сигнализация',
                        'Охранная сигнализация',
                        'Мусоропроводы',
                        'Лифты',
                    ],
                    items:{
                        one:[],
                        two:[]
                    },
                    fields:{
                        one:[
                            {key:'element',label:'Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте'},
                            {key:'nalichie',label:'Наличие на объекте'},
                            {key:'material',label:'Материал конструкции'},
                            {key:'srok_eks',label:'Срок эксплуатации с момента строительства или предыдущего капитального ремонта'},
                            {key:'kap_remont',label:'Требуется капитальный ремонт'},
                            {key:'obosnovanie',label:'Обоснование необходимости'},
                        ],
                        two:[
                            {key:'element',label:'Строительные конструкции замена и (или) восстановление которых планируются при капитальном ремонте'},
                            {key:'nalichie',label:'Наличие на объекте'},
                            {key:'srok_eks',label:'Срок эксплуатации с момента строительства или предыдущего капитального ремонта'},
                            {key:'kap_remont',label:'Требуется капитальный ремонт'},
                            {key:'obosnovanie',label:'Обоснование необходимости'},
                        ]
                    }
                },
                waited:{
                    fields:[
                        {key:'aim',label:'Цели и задачи'},
                        {key:'plan',label:'Планируемый показатель'},
                        {key:'changes',label:'Единица измерения'},
                    ],
                    items:[]
                },
                risks:{
                    fields:[
                        {key:'types',label:'Виды рисков'},
                        {key:'poison',label:'Отрицательные влияния'},
                        {key:'protect',label:'Способы защиты'},
                    ],
                    items:[]
                },
                sved2Href: [1.2,1.3,4.3, 4.2, 7.2,7.3,7.41,8.01],
                sved2Doc:[1.1, 1.4, 2, 3,1.3,4.3, 4.1, 4.4, 5, 6, 7.1, 7.3, 7.4, 8],
            };



        },
        computed: {
            ...mapGetters(['getUser']),
        },
        async mounted() {
            this.obj_id = this.$route.params.id;
            await this.requestUser();
            await this.getStatus();
            await this.getObject();

            console.log(this.items.id_founder === 1);

            await this.createChart();
            this.permission = window.Permission;

            await window.addEventListener("load", this.createChart);
            await window.addEventListener("resize", this.createChart);

            this.canChange = window.Permission === 'root' | window.canChange || false;
        },
        methods: {
            tableToExel(){
                var tableToExcel = (function() {
                    var uri = 'data:application/vnd.ms-excel;base64,'
                        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
                        , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
                        , format = function(s, c) {
                        return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; })
                    }
                        , downloadURI = function(uri, name) {
                        var link = document.createElement("a");
                        link.download = name;
                        link.href = uri;
                        link.click();
                    }

                    return function(table, name, fileName) {
                        console.log(table);
                        if (!table.nodeType) table = document.getElementById(table)
                        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
                        var resuri = uri + base64(format(template, ctx))
                        downloadURI(resuri, fileName);
                    }
                })();
                tableToExcel('exportPlan','Смета', 'Ремрайон_смета.xls');
            },
            checkFOIV(){
                return this.items.id_founder === 1;

            },
            async changeRealStatus(index){
                let data = new FormData();
                data.append('value','real_status');
                data.append('real_status',index);
                await Axios.post(`/program/object/set-value/${this.items.id}`,data, {
                        headers: {
                            "X-CSRF-Token": this.csrf
                        }
                    }
                ).then(response=>{
                    if(!response.data.success)
                        response.data.errors.forEach(item=>{
                            this.setBanner('danger',item)
                        })
                });
                this.realStatus = index;
            },
            fileInput(index) {
                let graph = document.querySelector(`#file_input_${index}`);
                this.svedenia2[index].file = graph.files[0];

            },
            debugItem(item, sved2, index) {
                //Опытным путем было выяснено что индек считается вот таким образом (item.step + 1)

                console.group('debugItem' + index);
                console.log(item);
                console.log(sved2);
                console.log(item.step + 1)
                console.groupEnd();
            },
            setStatus(staus){
                let data = new FormData();
                data.append('value','status');
                data.append('status',staus);
                Axios.post(`/program/object/set-value/${this.items.id}`,data, {
                        headers: {
                            "X-CSRF-Token": this.csrf
                        }
                    }
                ).then(response=>{
                    if(!response.data.success)
                        response.data.errors.forEach(item=>{
                            this.setBanner('danger',item)
                        })
                })
            },
            ObjectOpis(event){
                let data = new FormData();
                data.append('value','object_opis');
                data.append('object_opis',this.items.object_opis);
                Axios.post(`/program/object/set-value/${this.items.id}`,data, {
                        headers: {
                            "X-CSRF-Token": this.csrf
                        }
                    }
                ).then(response=>{
                    if(!response.data.success)
                        response.data.errors.forEach(item=>{
                            this.setBanner('danger',item)
                        })
                })
            },
            async setChart() {
                const months = [
                    'январь',
                    'февраль',
                    'март',
                    'апрель',
                    'май',
                    'июнь',
                    'июль',
                    'август',
                    'сентябрь',
                    'октябрь',
                    'ноябрь',
                    'декабрь'
                ];
                let bars = document.querySelectorAll('.chart-bars li');
                bars.forEach((el,index)=>{
                    let item = this.svedenia.items[index];
                    let date = null;
                    if (item && item.date_event_start && item.date_event_end) {
                        let sDate = months[parseInt(item.date_event_start.split('-')[1])];
                        let eDate = months[parseInt(item.date_event_end.split('-')[1])];

                        date = sDate + '-' + eDate;
                    }
                    el.dataset.duration = date
                });

            },
            createChart(e = 'load') {
                const days = document.querySelectorAll(".chart-values li");
                const tasks = document.querySelectorAll(".chart-bars li");
                const daysArray = [...days];


                tasks.forEach(el => {
                    const duration = el.dataset.duration.split("-");
                    const startDay = duration[0];

                    const endDay = duration[1];
                    let left = 0,
                        width = 0;

                    if (startDay && startDay.length && startDay.endsWith("½")) {
                        const filteredArray = daysArray.filter(day => day.textContent == startDay.slice(0, -1));
                        left = filteredArray[0].offsetLeft + filteredArray[0].offsetWidth / 2;
                    } else {
                        const filteredArray = daysArray.filter(day => day.textContent == startDay);
                        if (filteredArray.length)
                            left = filteredArray[0].offsetLeft;
                    }

                    if (endDay && endDay.length && endDay.endsWith("½")) {
                        const filteredArray = daysArray.filter(day => day.textContent == endDay.slice(0, -1));
                        if (filteredArray)
                            width = filteredArray[0].offsetLeft + filteredArray[0].offsetWidth / 2 - left;
                    } else {
                        const filteredArray = daysArray.filter(day => day.textContent == endDay);
                        if (filteredArray.length)
                            width = filteredArray[0].offsetLeft + filteredArray[0].offsetWidth - left;
                    }

                    // apply css
                    el.style.left = `${left - 40}px`;
                    el.style.width = `${width}px`;
                    el.style.height = '20px';
                    if (e && e === 'load') {
                        el.style.backgroundColor = el.dataset.color;
                        el.style.opacity = 1;
                    }
                });

            },
            ...mapActions(['requestUser']),
            sendData(item){
                let data = new FormData();
                Object.keys(item).forEach(key=>{
                    data.append(key,item[key]);
                })
                Axios.post(`/program/object/send-event/${this.obj_id}`,data,{
                    headers: {
                        "X-CSRF-Token": this.csrf
                    }
                }).then(response=>console.log(response.data))
            },
            addRow(index,byStep = null){
                this.svedenia2.splice(index,0,{
                    step: byStep || Math.round((this.svedenia2[index-1].step+0.01+Number.EPSILON)*1000)/1000 ,
                    id_event:null,
                    step_name:'',
                    date_event_start: null,
                    date_event_end: null,
                    cost_real:null,
                    sum_bud_fin:null,
                    access_document:null,
                    fin_vnebud_ist:null,
                    is_nessesary: null,
                    done:false,
                    doneExpert:false,
                    comment:'',
                    commentExpert:'',
                    parent:false,
                    canDelete:true,
                });
                this.sved2Doc.push(byStep || Math.round((this.svedenia2[index-1].step+0.01+Number.EPSILON)*1000)/1000+1)
                this.sved2Href.push(byStep || Math.round((this.svedenia2[index-1].step+0.01+Number.EPSILON)*1000)/1000+1)
            },
            async deleteRow(index){
                if (this.svedenia2[index-1].canDelete){
                    let data = new FormData();
                    data.append('step',this.svedenia2[index-1].step);
                    await Axios.post(`/program/object/del-event/${this.obj_id}`,data,{
                        headers: {
                            "X-CSRF-Token": this.csrf
                        }
                    }).then(resp=>{
                        if(resp.data.success)
                            this.svedenia2.splice(index-1,1);
                    })

                }
            },
            actionHendler(event) {
                event.preventDefault();
                if(document.querySelector(`#user_${window.currentUser}`) || window.Permission === 'dep') {
                    window.location = event.target.href
                } else {
                    this.setBanner('danger', 'Сначала добавте комментарий!')
                }
            },
            setBanner(variant, message) {
                this.bannerInfo.unshift({
                    show: true,
                    variant: variant,
                    message: message
                });
                setTimeout(() => {
                    this.resetBanners();
                }, 1500);
            },
            resetBanners() {
                this.bannerInfo.pop();
            },
            getEl(arr,index){
                let el = null;
                arr.forEach(item=>{
                    if (item.element == index) {
                        el = item;
                        return false;
                    }
                });
                return el;
            },
            async getStatus() {
                Axios.get(`/api/get-status/${this.obj_id}`).then((res) =>{
                    this.status.label = res.data.label;
                    this.realStatus = res.data.real_status;

                    let dep = res.data.dep_status;
                    if(dep == 'not') {
                        this.dep_status.label = 'В обработке';
                        this.dep_status.color = 'secondary'
                    } else if(dep == 'approved') {
                        this.dep_status.label = 'Рассмотрено ДЭП';
                        this.dep_status.color = 'success'
                    } else if(dep == 'rejected') {
                        this.dep_status.label = 'Резерв';
                        this.dep_status.color = 'warning'
                    }

                    let dku = res.data.dku_status;
                    if(dku == 'not') {
                        this.dku_status.label = 'В обработке';
                        this.dku_status.color = 'secondary'
                    } else if(dku == 'approved') {
                        this.dku_status.label = 'Рассмотрено ДКУ';
                        this.dku_status.color = 'success'
                    } else if(dku == 'rejected') {
                        this.dku_status.label = 'Резерв';
                        this.dku_status.color = 'warning'
                    }

                    if(res.data.id == 2) {
                        this.show.dep = true
                    }
                    if(res.data.dep_status == 'approved') {
                        this.show.dku = true
                    }


                    let color = '';
                    if(res.data.id == 1) {
                        color = 'secondary'
                    } else if (res.data.id == 2) {
                        color = 'success'
                    } else if (res.data.id == 3) {
                        color = 'danger'
                    } else if (res.data.id == 4) {
                        color = 'warning'
                    }
                    this.status.variant = color;

                    this.real = res.data.id == 2 && dep=='approved';

                })
            },
            isFloat(x) { return !!(x % 1); },
            async getObject(){
                await Axios.get(`/api/get-object/${this.obj_id}`).then(res=>{
                    this.fromServer = JSON.parse(res.data);
                    this.items = this.fromServer.object;
                    this.items.org_name = this.fromServer.organization.name;
                    this.items.id_founder = this.fromServer.organization.id_founder;
                    this.docs = this.fromServer.docs;
                    this.org_id = JSON.parse(res.data).org_id;

                    console.log(this.items)

                    let c=0.0, v=0.0,b=0.0;
                    console.log(this.fromServer);
                    this.fromServer.svedenia.forEach((item,index)=>{
                        c+=Number(item.model.cost_real);
                        if (item.model.done)
                            this.s_bud_f+=parseFloat(item.model.cost_real);
                        v+=Number(item.model.sum_bud_fin);
                        b+=Number(item.model.fin_vnebud_ist);
                        this.svedenia2.forEach(item2=>{
                            if (item2.step == item.model.step) {
                                item2.id = item.model.id;
                                item2.date_event_start = item.model.date_event_start;
                                item2.date_event_end = item.model.date_event_end;
                                item2.cost_real = item.model.cost_real;
                                item2.access_document = item.model.access_document;
                                item2.sum_bud_fin = item.model.sum_bud_fin;
                                item2.fin_vnebud_ist = item.model.fin_vnebud_ist;
                                item2.id_event = item.model.id;
                                item2.done = item.model.done == 1;
                                if (item.file) {
                                    item2.file = {
                                        name: item.file
                                    }
                                }
                                item2.doneExpert = item.model.doneExpert == 1;
                                item2.comment = item.model.comment;
                                item2.commentExpert = item.model.commentExpert;
                            }
                        });
                        this.svedenia.items.push({
                            index:index+1,
                            step:this.svedenia.labels[index],
                            is_nessesary:item.model.is_nessesary ? 'Да' : 'Нет',
                            date_event_start:item.model.date_event_start,
                            date_event_end:item.model.date_event_end,
                            cost_real:item.model.cost_real,
                            sum_bud_fin:item.model.sum_bud_fin,
                            fin_vnebud_ist:item.model.fin_vnebud_ist,
                        })
                    });
                    this.fromServer.svedenia2.sort((p,n)=>p.model.step - n.model.step)
                    this.fromServer.svedenia2.forEach((item,index)=>{
                        c+=Number(item.model.cost_real);
                        v+=Number(item.model.sum_bud_fin);
                        b+=Number(item.model.fin_vnebud_ist);
                        this.svedenia2.forEach(item2=>{
                            if (this.svedenia2.find(i=>i.step == item.model.step)){
                                if (this.isFloat(item2.step) && item2.step == item.model.step) {
                                    item2.id = item.model.id;
                                    item2.date_event_start = item.model.date_event_start;
                                    item2.date_event_end = item.model.date_event_end;
                                    item2.cost_real = item.model.cost_real;
                                    item2.sum_bud_fin = item.model.sum_bud_fin;
                                    item2.fin_vnebud_ist = item.model.fin_vnebud_ist;
                                    item2.id_event = item.model.id_event;
                                    item2.done = item.model.done == 1;
                                    item2.access_document = item.model.access_document;
                                    item2.doneExpert = item.model.doneExpert == 1;
                                    if (item.file) {
                                        item2.file = {
                                            name: item.file
                                        }
                                    }
                                    item2.comment = item.model.comment;
                                    item2.commentExpert = item.model.commentExpert;
                                }
                            }
                            else {
                              //  console.log(parseFloat(item.model.step));
                                let i = -1;
                                let s = 0.01;
                                while (i === -1) {

                                    i = this.svedenia2.map(e => {
                                        return e.step
                                    }).indexOf(parseFloat(item.model.step) - s);
                                   // console.log(i,s);
                                    s = Math.round((s+0.01+Number.EPSILON)*1000)/1000

                                }
                                this.addRow(i,parseFloat(item.model.step));
                                let l = this.svedenia2.find(e=>e.step == item.model.step);

                                l.id = item.model.id;
                                l.step_name = item.model.step_name;
                                l.date_event_start = item.model.date_event_start;
                                l.date_event_end = item.model.date_event_end;
                                l.cost_real = item.model.cost_real;
                                l.sum_bud_fin = item.model.sum_bud_fin;
                                l.fin_vnebud_ist = item.model.fin_vnebud_ist;
                                l.id_event = item.model.id_event;
                                l.done = item.model.done == 1;
                                l.access_document = item.model.access_document;
                                l.doneExpert = item.model.doneExpert == 1;
                                if (item.file) {
                                    l.file = {
                                        name: item.file
                                    }
                                }
                                l.comment = item.model.comment;
                                l.commentExpert = item.model.commentExpert;
                            }
                        });
                    });

                    this.svedenia2.sort((a,b)=>{return a.step-b.step});

                //    console.log(this.svedenia2)

                    this.svedenia.items.push({
                        step:'Готово',
                        cost_real:c.toFixed(3),
                        sum_bud_fin:v.toFixed(3),
                        fin_vnebud_ist:b.toFixed(3),
                    });
                    this.necessary.labels.forEach((item,index)=>{
                        let el = this.getEl(this.fromServer.necessary,index);
                        if (!el) {
                            if (index < 17) {
                                this.necessary.items.one.push({
                                    element: item,
                                    nalichie: null,
                                    material: null,
                                    srok_eks: null,
                                    kap_remont: null,
                                    obosnovanie: null,
                                })
                            }
                            else{
                                this.necessary.items.two.push({
                                    element: item,
                                    nalichie: null,
                                    srok_eks: null,
                                    kap_remont: null,
                                    obosnovanie: null,
                                })
                            }
                        }else {
                            if (index < 17) {
                                this.necessary.items.one.push({
                                    element: item,
                                    nalichie: el.nalichie == '1' ? 'Да' : 'Нет',
                                    material: el.nalichie == '1' ? el.material : '',
                                    srok_eks: el.nalichie == '1' ? el.srok_eks : '',
                                    kap_remont: el.nalichie == '1' ? el.kap_remont ? 'Да' : 'Нет' : '',
                                    obosnovanie: el.nalichie == '1' ? el.kap_remont ? item.obosnovanie : '' : '',
                                })

                            } else {
                                this.necessary.items.two.push({
                                    element: item,
                                    nalichie: el.nalichie == '1' ? 'Да' : 'Нет',
                                    srok_eks: el.nalichie == '1' ? el.srok_eks : '',
                                    kap_remont: el.nalichie == '1' ? el.kap_remont ? 'Да' : 'Нет' : '',
                                    obosnovanie: el.nalichie == '1' ? el.kap_remont ? el.obosnovanie : '' : '',
                                })

                            }
                        }
                    });

                    let w0 = this.getEl(this.fromServer.waited,0);
                    let w1 = this.getEl(this.fromServer.waited,1);
                    let w2 = this.getEl(this.fromServer.waited,2);
                    let w3 = this.getEl(this.fromServer.waited,3);
                    let w4 = this.getEl(this.fromServer.waited,4);
                    this.waited.items.push({
                        aim:'Проведение капитального ремонта, общая площадь',
                        plan:w0?.plan,
                        changes:'кв.м'
                    },{
                        aim:'Вовлечение в хозяйственную деятельность за счет проведенного капитального ремонта, общая площадь',
                        plan:w1?.plan,
                        changes:'кв.м'
                    },{
                        aim:'Снижение затрат на эксплуатацию',
                        plan:w2?.plan == '1' ? 'Да' : 'Нет',
                        changes:''
                    },{
                        aim:'Повышение энергоэффективности',
                        plan:w3?.plan == '1' ? 'Да' : 'Нет',
                        changes:''
                    },{
                        aim:'Восстановление (ремонт, реставрация, за исключением реконструкции) объектов культурного наследия',
                        plan:w4?.plan == '1' ? 'Да' : 'Нет',
                        changes:''
                    });
                    for (let i = 5; i<this.fromServer.waited.length;i++){
                        let el = this.fromServer.waited[i];
                        this.waited.items.push({
                            aim:el.aim,
                            plan:el.plan,
                            changes:el.changes
                        });
                    }
                    if (this.fromServer.risks) {
                        this.fromServer.risks.forEach(item => {
                            this.risks.items.push({
                                types: item.types,
                                poison: item.poison,
                                protect: item.protect,
                            });
                        });
                    }


                });

                this.svedenia2.some(item=>{
                    if (item.done == 0){
                        if (item.date_event_end) {
                            this.dateStatus = new Date(item.date_event_end).toLocaleDateString();
                            return true;
                        }
                    }
                });

                await this.setChart();
            },
            getIznos(iznos) {
                let izn = parseInt(iznos);
                if (izn === 0) {
                    return "Менее 20%";
                } else if (izn === 1) {
                    return "От 20% до 50%";
                } else if (izn === 2) {
                    return "От 50% до 70%";
                } else if (izn === 3) {
                    return "От 70% до 90%";
                } else if (izn === 4) {
                    return "Более 90%";
                }
            },
            getMonth(step){
                return step > 7 ? this.months[Math.round((step-7)*100)-1] : step + 1;

            }
        }
    };
</script>

<style>
    .normal-font-weight-for-sell {
        font-weight: normal !important;
    }
    .vertical-horizontal-align {
        vertical-align: middle !important;
        text-align: center;
    }

    :root {
        --divider: lightgrey;
    }
    .labels-for-chart {
        z-index: 1;
        width: 1090px;
        margin-left: 5px;
        position: absolute;
        top: 87px;
        left: 5px;
    }
    .labels-for-chart > li {
        margin-top: 10px;
        border-bottom: 1px solid grey;
    }
    .charter1 {
        z-index: 1;
        position: absolute;
        top: 52px;
        left: 5px;
        height: 320px;
        width: 600px;
        background-color: white;
    }
    .charter2 {
        z-index: 1;
        position: absolute;
        top: 52px;
        left: 530px;
        height: 320px;
        width: 200px;
        background: linear-gradient(to right, white 60%, transparent 100%);
    }
    ul {
        padding-inline-start: 0px !important;
        list-style: none;
    }
    a {
        text-decoration: none;
        color: inherit;
    }
    body {
        background: var(--body);
        font-size: 16px;
        font-family: sans-serif;
    }
    .chart-wrapper {
        max-width: 1000px;
        padding: 0 10px;
        margin: 0 auto;
        margin-left: 700px;
    }
    .chart-wrapper .chart-values {
        position: relative;
        display: flex;
        margin-bottom: 20px;
        font-weight: bold;
    }
    .chart-wrapper .chart-values li {
        flex: 1;
        min-width: 80px;
        text-align: center;
    }
    .chart-wrapper .chart-values li:not(:last-child) {
        position: relative;
    }
    .chart-wrapper .chart-values li:not(:last-child)::before {
        content: '';
        position: absolute;
        right: 0;
        height: 300px;
        border-right: 1px solid var(--divider);
    }
    .chart-wrapper .chart-bars li {
        position: relative;
        color: var(--white);
        margin-bottom: 15px;
        font-size: 16px;
        border-radius: 20px;
        padding: 10px 20px;
        width: 0;
        opacity: 0;
        transition: all 0.65s linear 0.2s;
    }


    /* Анимация стрелочек и стили самих стрелочек */

    .cell-center-for-items {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .scope-to-animate {
        z-index: 999;
        height: 2px;
        width: 8px;
        background: grey;
        transition: 0.4s ease;
    }
    .scope-to-animate:first-child {
        display: block;
        position: absolute;
        transform: rotate(45deg);
        left: 25%;
        bottom: 35%;
    }
    .scope-to-animate:nth-child(2) {
        display: block;
        position: absolute;
        transform: rotate(-45deg);
        left: 45%;
        bottom: 35%;
    }
    .scope-to-animate:nth-child(3) {
        display: block;
        position: absolute;
        transform: rotate(45deg);
        left: 25%;
        bottom: 54%;
    }
    .scope-to-animate:nth-child(4) {
        display: block;
        position: absolute;
        transform: rotate(-45deg);
        left: 45%;
        bottom: 54%;
    }
    .label:hover .scope-to-animate:nth-child(1) {
        transform: rotate(-135deg);
        background: #5bc0de;
    }
    .label:hover .scope-to-animate:nth-child(2) {
        transform: rotate(135deg);
        background: #5bc0de;
    }
    .label:hover .scope-to-animate:nth-child(3) {
        transform: rotate(225deg);
        background: #5bc0de;
    }
    .label:hover .scope-to-animate:nth-child(4) {
        transform: rotate(-225deg);
        background: #5bc0de;
    }
    .hidden-file-input {
        display: none;
    }
    .label {
        position: relative;
        width: 28px;
    }
    .arrow {
        display: flex;
        align-items: center;
    }
    .arrow input[type="file"] {
        outline: 0;
        opacity: 0;
        pointer-events: none;
        user-select: none;
    }
    .arrow .label {
        height: 28px;
        border: 1px solid grey;
        border-radius: 5px;
        display: block;
        transition: border 300ms ease;
        cursor: pointer;
        text-align: center;
    }
    .arrow .label i {
        display: block;
        font-size: 42px;
    }
    .arrow .label i,
    .example-1 .label .title {
        color: grey;
        transition: 200ms color;
    }
    .arrow .label:hover {
        border: 2px solid #5bc0de;
    }
    .arrow .label:hover i,
    .example-1 .label:hover .title {
        color: #5bc0de;
    }
</style>