<template>
  <v-navigation-drawer
    fixed
    :clipped="$vuetify.breakpoint.lgAndUp"
    app
    v-model="drawer"
  >

    <v-list>
      <v-list-group
        v-for="item in menuItems"
        :key="item.title"
        :prepend-icon="item.action"
        no-action
        v-model="item.active"
      >
        <v-list-tile slot="activator">
          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
        <v-list-tile no-action v-for="subItem in item.items" :key="subItem.title" replace :to="{name:subItem.uri}" exact>
          <v-list-tile-content>
            <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
  import {CHANGE_NAV_BAR} from '@/vuex/types';
  export default {
    name: "NavBar",
    created(){
      this.menuItems.forEach((menuItem, index) => {
        let findUri = menuItem.items.some((item)=>{
          return item.uri === this.$route.name
        });
        if(findUri){
          this.menuItems[index].active = true
        }
      })
    },
    data(){
      return {
        menuItems: [
          {
            action: "store",
            title: "Магазины",
            active: false,
            items:[
              {
                title: "Магазины",
                uri: "Shops"
              },
              {
                title: "Смены Магазинов",
                uri: "ShopShifts"
              },
              {
                title: "Смены",
                uri: "Shifts"
              },
              {
                title: "Должности",
                uri: "Roles"
              },
              {
                title: "Типы магазинов",
                uri: "ShopTypes"
              },
              // {
              //   title: "Планновая загрузка",
              //   uri: "StaffPlans"
              // },
              // {
              //   title: "Грейды",
              //   uri: "ShopGrades"
              // }
            ]
          },
          {
            action: "devices",
            title: "Товары",
            active: false,
            items:[
              {
                title: "Товары",
                uri: "Products"
              },
              {
                title: "Группы товаров",
                uri: "ProductGroups"
              },
              {
                title: "Бренды товаров",
                uri: "ProductBrands"
              },
              {
                title: "Типы товаров",
                uri: "ProductTypes"
              },
              {
                title: "Движение товаров",
                uri: "ProductRemains"
              },
              {
                title: "Тип измерения",
                uri: "MeasureTypes"
              },
              // {
              //   title: "Планы группов товаров",
              //   uri: "ProductGroupPlans"
              // },
              // {
              //   title: "Типы планов группов товаров",
              //   uri: "ProductGroupPlanTypes"
              // }
            ]
          },
          {
            action: "devices_other",
            title: "Склады",
            active: false,
            items:[
              {
                title: "Склады",
                uri:"Warehouses"
              },
              {
                title: "Тип склада",
                uri:"WarehouseTypes"
              }
            ]
          },
          {
            action: "people",
            title: "Пользователи",
            active: false,
            items:[
              {
                title: "Сотрудники",
                uri: "Users"
              },
              {
                title: "Клиенты",
                uri: "Clients"
              },
            ]
          },
          {
            action: "business",
            title: "Прочее",
            active: false,
            items:[
              {
                title: "Дивизионы",
                uri: "Divisions"
              },
              {
                title: "Компании",
                uri: "Companies"
              },
              {
                title: "Регионы",
                uri: "Regions"
              },
              {
                title: "Города",
                uri: "Cities"
              }
            ]
          },
          {
            action: "show_chart",
            title: "Динамические отчеты",
            active: false,
            items:[
              {
                title: "Аналитика",
                uri: "Analytics"
              },
              {
                title: "Посещаемость",
                uri: "VisitLogs"
              },
            ]
          },
          {
            action: "camera_roll",
            title: "Чеки",
            active: false,
            items:[
              // {
              //   title: "Детали чека",
              //   uri:"CheckDetails"
              // },
              {
                title: "Чеки",
                uri:"CheckHeaders"
              },
              {
                title: "Типы чеков",
                uri:"CheckTypes"
              },
              {
                title: "Операции чеков",
                uri:"CheckOperations"
              },
              {
                title: "Описание оплат",
                uri:"CashDesc"
              },
            ]
          },
          {
            action: "settings",
            title: "Настройки",
            active: false,
            items:[
              // {
              //   title: "Коэффициенты",
              //   uri:"Coeffs"
              // },
              {
                title: "Скидки",
                uri:"Discounts"
              },
              // {
              //   title: "Тип коэффициентов",
              //   uri:"CoeffTypes"
              // },
              {
                title: "Операции",
                uri: "Operations"
              },
              {
                title: "Загрузка отчетов",
                uri: "UploadReport"
              },
              {
                title: "Карты лояльности",
                uri: "Cards"
              }
            ]
          }
        ]
      }
    },
    computed:{
      drawer:{
          get(){
            return this.$store.state.templateSettings.drawer
          },
          set(val){
            this.$store.commit(CHANGE_NAV_BAR, val)
          }
      }
    }
  }
</script>
