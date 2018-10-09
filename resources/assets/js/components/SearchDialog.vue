<template>
  <v-dialog v-model="$store.state.navi.searchDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
    <v-btn slot="activator" icon>
      <v-icon>search</v-icon>
    </v-btn>
    <v-card>
      <v-toolbar dark color="indigo">
        <v-toolbar-title>Cauta in WeStore</v-toolbar-title>
        <v-spacer/>
        <v-btn icon dark @click.native="$store.state.navi.searchDialog = false">
          <v-icon>close</v-icon>
        </v-btn>
      </v-toolbar>
      <v-container fluid fill-height grid-list-sm style="margin-top: 15vh">
        <v-layout align-center justify-center row wrap class="text-xs-center">
          <v-flex xs12 sm10 md8 lg6>
            <div style="font-size: 4.8rem; margin-bottom: 2rem"><span style="color: #C62828">We</span><span style="color: #3f51b5">Store</span></div>
            <v-card class="elevation-18">
              <v-text-field
              v-model="params.search"
              :clearable="true"
              :autofocus="true"
              :loading="loading"
              @keydown.enter.native="searchProducts"
              light
              solo
              color="indigo"
              flat
              hide-details
              placeholder="Cauta in WeStore"
              single-line
              >
              <template slot="append">
                <v-icon color="indigo"  :disabled="!hasChanges" @click="searchProducts">search</v-icon>
              </template>
              <template slot="prepend-inner">
                <v-btn icon
                color="indigo"
                flat
                dark
                @click="isEditing = !isEditing"
                style="margin-left: -0.5rem"
                >
                <v-icon  v-if="isEditing">close</v-icon>
                <v-icon  v-else>filter_list</v-icon>
              </v-btn>
              <v-btn icon
              color="transparent"
              flat
              dark
              style="margin-left: -0.5rem"
              >
              <v-avatar class="elevation-20" size="32" style="margin-right: 0.3rem">
                <img src="/icons/icon-36.png">
              </v-avatar>
            </v-btn>
          </template>
        </v-text-field>
      </v-card>
    </v-flex>
  </v-layout>
</v-container>
<v-slide-y-transition>
  <v-container v-show="isEditing" fluid fill-height grid-list-sm style="margin-top: -30px">
    <v-layout align-center justify-center row wrap class="text-xs-center">
      <v-flex xs12 sm10 md8 lg6>
        <v-card
        class="hide-overflow elevation-18"
        light
        >
        <v-card-text style="margin-bottom: 1.2rem">
          <v-layout row wrap>
            <v-flex xs12 sm6>
              <v-autocomplete
              v-model="selectedCategory"
              :disabled="!isEditing"
              :items="categories"
              :filter="customFilter"
              clearable
              hide-details
              hide-selected
              color="indigo"
              :return-object="true"
              item-text="name"
              item-value="id"
              label="Categorie">
              <template slot="no-data">
                <v-list-tile>
                  <v-list-tile-title>
                    Nu am gasit aceasta
                    <strong>categorie</strong>
                  </v-list-tile-title>
                </v-list-tile>
              </template>
            </v-autocomplete>
          </v-flex>
          <v-flex xs12 sm6>
            <v-autocomplete
            v-model="selectedBrand"
            :disabled="!isEditing"
            :items="brands"
            :filter="customFilter"
            color="indigo"
            item-text="name"
            :return-object="true"
            clearable
            hide-details
            hide-selected
            label="Brand"
            >
            <template slot="no-data">
              <v-list-tile>
                <v-list-tile-title>
                  Nu am gasit acest
                  <strong>brand</strong>
                </v-list-tile-title>
              </v-list-tile>
            </template></v-autocomplete>
          </v-flex>
          <v-flex xs12 sm6>
            <v-autocomplete
            v-model="params.affiliate"
            :disabled="!isEditing"
            :items="affiliates"
            :filter="customFilter"
            color="indigo"
            item-text="name"
            item-value="name"
            clearable
            hide-details
            hide-selected
            label="Magazin"
            >
            <template slot="no-data">
              <v-list-tile>
                <v-list-tile-title>
                  Nu am gasit acest
                  <strong>magazin</strong>
                </v-list-tile-title>
              </v-list-tile>
            </template></v-autocomplete>
          </v-flex>
          <v-flex xs12 sm6>
            <v-autocomplete
            v-model="params.filter"
            :disabled="!isEditing"
            :items="filters"
            :filter="customFilter"
            color="indigo"
            item-text="name"
            item-value="abbr"
            clearable
            hide-details
            hide-selected
            label="Sorteaza"
            >
            <template slot="no-data">
              <v-list-tile>
                <v-list-tile-title>
                  Nu am gasit aceasta
                  <strong>sortare</strong>
                </v-list-tile-title>
              </v-list-tile>
            </template></v-autocomplete>
          </v-flex>
        </v-layout>
      </v-card-text>
    </v-card>
  </v-flex>
</v-layout>
</v-container>
</v-slide-y-transition>
</v-card>
</v-dialog>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'
export default {
  name: 'SearchDialog',
  components: {
  },
  data: () => ({
    search: '',
    loading: false,
    categories: [],
    brands: [],
    hasSaved: false,
    hasChanges: false,
    isEditing: null,
    selectedBrand: '',
    selectedCategory: '',
    params: {
      search: '',
      affiliate: null,
      filter: null,
      brand: null,
      category: null,
      page: 1
    },
    filters: [
      { name: 'Pret crescator', abbr: 'pcr', id: 1 },
      { name: 'Pret descrescator', abbr: 'pdc', id: 2 },
      { name: 'Pret promotional', abbr: 'ppr', id: 3 },
      { name: 'In ordinea adaugarii', abbr: 'ioa', id: 4 },
      { name: 'Relevanta cautarii', abbr: 'rel', id: 5 },
    ],
    affiliates: []
  }),
  computed: mapGetters({
    user: 'auth/user'
  }),
  watch: {
    isEditing (val) {

      if(!this.$store.state.brand.total)
      this.$store.dispatch('brand/fetchBrands').then(() => {
        this.brands = this.$store.state.brand.brands
      })

      if(!this.$store.state.affiliate.total)
      this.$store.dispatch('affiliate/fetchAffiliates').then(() => {
        this.affiliates = this.$store.state.affiliate.affiliates
      })

      if(!this.$store.state.category.total)
      this.$store.dispatch('category/fetchCategories').then(() => {
        this.categories = this.$store.state.category.categories
      })

    },
    'params.search': function()
    {
      if(this.params.search)
      {
        if(this.params.search.length > 3)
          this.hasChanges = true
          else {
            if(this.params.brand || this.params.affiliate || this.params.filter && this.params.filter != 'rel' || this.params.category)
            this.hasChanges = true
            else {
              this.hasChanges = false
            }
          }
      }
      else {
        if(this.params.brand || this.params.affiliate || this.params.filter && this.params.filter != 'rel' || this.params.category)
        this.hasChanges = true
        else {
          this.hasChanges = false
        }
      }
    },
    'params.filter': function()
    {
      if(this.params.filter != 'rel' && this.params.filter != null)
      this.hasChanges = true
      else {
        if(this.params.brand || this.params.affiliate || this.params.category || this.params.search && this.params.search.length > 3)
        this.hasChanges = true
        else {
          this.hasChanges = false
        }
      }
    },
    'selectedBrand': function()
    {
      if(this.selectedBrand)
      this.params.brand = this.selectedBrand.id
      else {
          this.params.brand = null
      }
    },
    'selectedCategory': function()
    {
      if(this.selectedCategory)
      this.params.category = this.selectedCategory.id
      else {
          this.params.category = null
      }
    },
    'params.brand': function()
    {
      if(this.params.brand)
      this.hasChanges = true
      else {
        if(this.params.category || this.params.affiliate || this.params.filter && this.params.filter != 'rel' || this.params.search && this.params.search.length > 3)
        this.hasChanges = true
        else {
          this.hasChanges = false
        }
      }
    },
    'params.affiliate': function()
    {
      if(this.params.affiliate)
      this.hasChanges = true
      else {
        if(this.params.brand || this.params.category || this.params.filter && this.params.filter != 'rel' || this.params.search && this.params.search.length > 3)
        this.hasChanges = true
        else {
          this.hasChanges = false
        }
      }
    },
    'params.category': function()
    {
      if(this.params.category)
      this.hasChanges = true
      else {
        if(this.params.brand || this.params.affiliate || this.params.filter && this.params.filter != 'rel' || this.params.search && this.params.search.length > 3)
        this.hasChanges = true
        else {
          this.hasChanges = false
        }
      }
    },


  },
  created ()
  {
    this.params = this.$store.state.product.params
  },
  methods: {
    async searchProducts()
    {
      if(this.hasChanges){
        this.loading = true
        if(this.params.search)
        var message = `Incepem cautarea dupa ${this.params.search}`
        if(this.params.category)
        message = `${message} , categoria ${this.selectedCategory.name}`
        if(this.params.brand)
        message = `${message} , brand ${this.selectedBrand.name}`
        if(this.params.affiliate)
        message = `${message} , magazin ${this.params.affiliate}`
        if(this.params.filter === 'ppr')
        message = `${message} , cu pret promotional`
        const searchSnackbar = {
          value: true,
          message: message,
          type: 'indigo',
          avatar: false,
          icon: 'store',
          mode: '',
          timeout: 6000
        }
        await this.$store.dispatch('navi/setSnackbar', searchSnackbar)
        await this.$store.dispatch('product/fetchProducts', this.params)

        if(this.$store.state.product.params.search)
        {var message = `Am gasit ${this.$store.state.product.total} rezultate pentru cautarea ${this.$store.state.product.params.search}`
          if(this.params.category)
        message = `${message} , categoria ${this.selectedCategory.name}`
        if(this.params.brand)
        message = `${message} , brand ${this.selectedBrand.name}`
        if(this.params.affiliate)
        message = `${message} , magazin ${this.params.affiliate}`
        if(this.params.filter === 'ppr')
        message = `${message} , cu pret promotional`}
        else {
          var message = `Am gasit ${this.$store.state.product.total} produse`
          if(this.params.category)
          message = `${message} , categoria ${this.selectedCategory.name}`
          if(this.params.brand)
          message = `${message} , brand ${this.selectedBrand.name}`
        if(this.params.affiliate)
        message = `${message} , magazin ${this.params.affiliate}`
        if(this.params.filter === 'ppr')
        message = `${message} , cu pret promotional`
      }

        const snackbar = {
          value: true,
          message: message,
          type: 'indigo',
          avatar: false,
          icon: 'store',
          mode: '',
          timeout: 6000
        }
        await this.$store.dispatch('navi/setSnackbar', snackbar)
        window.scrollTo(0,0)
        this.loading = false
        if(this.$route.name !== 'products')
        this.$router.push({ name: 'products' })
        this.$store.state.navi.searchDialog = false
      }


    },
    customFilter (item, queryText, itemText) {
      const textOne = item.name.toLowerCase()
      const searchText = queryText.toLowerCase()
      return textOne.indexOf(searchText) > -1
    },
    save () {
      this.isEditing = !this.isEditing
      this.hasSaved = true
    }
  }
}
</script>
