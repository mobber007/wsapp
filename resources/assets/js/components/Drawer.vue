<template>
  <v-navigation-drawer
  v-model="$store.state.navi.drawer"
  fixed
  dark
  class="faded-indigo"
  app
  >
  <v-list>
    <v-list-tile v-if="user" avatar style="height: 72px" class="my-2 align-center justify-center">
      <v-list-tile-avatar size="48" style="margin-bottom: -0.75em">
        <img :src="user.avatar" alt="">
      </v-list-tile-avatar>
      <v-list-tile-title style="margin-bottom: -0.75em; margin-left: 0.75em; font-size: medium" v-text="`${user.name}  ${user.last_name[0]}.`"/>
      <v-spacer/>
      <v-btn icon style="margin-bottom: -0.75em; margin-right: -0.75em" @click="logout()">
        <v-icon>lock_open</v-icon>
      </v-btn>
    </v-list-tile>
    <v-list-tile v-else="" avatar style="height: 72px" class="my-2 align-center justify-center">
      <v-list-tile-avatar size="48" style="margin-bottom: -0.75em">
        <img :src="`https://randomuser.me/api/portraits/men/20.jpg`" alt="">
      </v-list-tile-avatar>
      <template v-if="!user">
        <v-list-tile-title style="margin-bottom: -0.75em; margin-left: 0.75em; font-size: medium" v-text="guest"/>
        <LoginWithFacebook/>
      </template>
    </v-list-tile>
    <v-divider/>
    <v-list-tile :to="{ name: 'home' }" :active-class="`drawer-active`">
      <v-list-tile-action>
        <v-icon>home</v-icon>
      </v-list-tile-action>
      <v-list-tile-content>
        <v-list-tile-title>Acasa</v-list-tile-title>
      </v-list-tile-content>
      <v-spacer/>
      <v-divider vertical style="margin-right: -1em"/>
      <v-list-tile-action class="text-xs-center align-center">
        <v-icon v-if="rname.indexOf('home') < 0">keyboard_arrow_right</v-icon>
        <template v-else="">
          <v-icon color="warning" v-if="!$store.state.navi.contactDialog">touch_app</v-icon>
          <v-icon v-else="">keyboard_arrow_right</v-icon>
        </template>
      </v-list-tile-action>
    </v-list-tile>
    <v-divider/>
    <v-list-tile :to="{name: 'products'}" :active-class="`drawer-active`">
      <v-list-tile-action>
        <v-icon>store</v-icon>
      </v-list-tile-action>
      <v-list-tile-content>
        <v-list-tile-title>Produse</v-list-tile-title>
      </v-list-tile-content>
      <v-spacer/>
      <v-divider vertical style="margin-right: -1em"/>
      <v-list-tile-action class="text-xs-center align-center">
        <v-icon v-if="rname.indexOf('products') < 0">keyboard_arrow_right</v-icon>
        <template v-else="">
          <v-icon color="warning" v-if="!$store.state.navi.contactDialog">touch_app</v-icon>
          <v-icon v-else="">keyboard_arrow_right</v-icon>
        </template>
      </v-list-tile-action>
    </v-list-tile>
    <v-divider/>
    <v-list-tile :to="{name: 'promotions'}" :active-class="`drawer-active`">
      <v-list-tile-action>
        <v-icon>local_offer</v-icon>
      </v-list-tile-action>
      <v-list-tile-content>
        <v-list-tile-title>Promotii</v-list-tile-title>
      </v-list-tile-content>
      <v-spacer/>
      <v-divider vertical style="margin-right: -1em"/>
      <v-list-tile-action class="text-xs-center align-center">
        <v-icon v-if="rname.indexOf('promotions') < 0">keyboard_arrow_right</v-icon>
        <template v-else="">
          <v-icon color="warning" v-if="!$store.state.navi.contactDialog">touch_app</v-icon>
          <v-icon v-else="">keyboard_arrow_right</v-icon>
        </template>
      </v-list-tile-action>
    </v-list-tile>
    <v-divider/>
    <v-list-tile :to="{name: 'favorites'}" :active-class="`drawer-active`">
      <v-list-tile-action>
        <v-icon>favorite</v-icon>
      </v-list-tile-action>
      <v-list-tile-content>
        <v-list-tile-title>Wishlist</v-list-tile-title>
      </v-list-tile-content>
      <v-spacer/>
      <v-divider vertical style="margin-right: -1em"/>
      <v-list-tile-action class="text-xs-center align-center">
        <v-icon v-if="rname.indexOf('favorites') < 0">keyboard_arrow_right</v-icon>
        <template v-else="">
          <v-icon color="warning" v-if="!$store.state.navi.contactDialog">touch_app</v-icon>
          <v-icon v-else="">keyboard_arrow_right</v-icon>
        </template>
      </v-list-tile-action>
    </v-list-tile>
    <v-divider/>
    <v-list-tile @click="$store.state.navi.contactDialog = true">
      <v-list-tile-action>
        <v-icon>contact_mail</v-icon>
      </v-list-tile-action>
      <v-list-tile-content>
        <v-list-tile-title>Contact</v-list-tile-title>
      </v-list-tile-content>
      <v-spacer/>
      <v-divider vertical style="margin-right: -1em"/>
      <v-list-tile-action class="text-xs-center align-center">
        <v-icon v-if="!$store.state.navi.contactDialog">keyboard_arrow_right</v-icon>
        <v-icon color="warning" v-else="">touch_app</v-icon>
      </v-list-tile-action>
    </v-list-tile>
    <v-dialog v-model="$store.state.navi.contactDialog" max-width="500px">
     <v-card light>
       <v-toolbar dark color="indigo darken-2">
       <v-toolbar-title class="white--text">Contact</v-toolbar-title>
     <v-spacer></v-spacer>
     <v-btn icon @click.native="$store.state.navi.contactDialog = false">
       <v-icon>close</v-icon>
     </v-btn>
   </v-toolbar>
       <v-card-text class="text-xs-center">
         <v-container>
           <v-layout row wrap>
             <v-form ref="contact_form" v-model="valid" lazy-validation>
             <v-flex xs12 v-if="!user">
               <v-text-field label="Email" :rules="emailRules" v-model="contact_form.email" solo-inverted  flat hint="ex: adrian@exemplu.ro" required autofocus></v-text-field>
             </v-flex>
             <v-text-field v-model="contact_form.secret" style="display: none"></v-text-field>
             <v-flex xs12>
               <v-text-field label="Subiect" :rules="subjectRules" v-model="contact_form.subject" hint="ex: Sarbatori fericite!" solo-inverted flat required></v-text-field>
             </v-flex>
             <v-flex xs12>
               <v-textarea label="Mesaj" :rules="messageRules" v-model="contact_form.message" solo-inverted hint="ex: Imi place sa folosesc WeStore" flat style="min-height: 150px" required></v-textarea>
             </v-flex>
            <v-flex v-if="!user" xs12>
               <v-switch
               v-model="contact_form.accepted"
               :rules="acceptedRules"
               >
             <template slot="label">
               <div>Am citit si sunt de acord cu <a href="#">politica de confidentialitate</a></div>
             </template>
           </v-switch>
         </v-flex>
         <v-flex v-else="" xs12>
            <div>Ati acceptat <a href="#">politica de confidentialitate</a> pe data de {{user.accepted_at}}</div>
      </v-flex>

         </v-form>
           </v-layout>
         </v-container>

       </v-card-text>
       <v-card-actions>

           <a href="https://www.facebook.com/westore.ro/" target="_blank" style="text-decoration: none">
             <v-avatar size="32">
               <v-img avatar src="/storage/graphics/fb_64x64.png"/>
             </v-avatar>
           </a>
           <a href="https://www.instagram.com/westore.ro/" target="_blank" style="text-decoration: none">
             <v-avatar size="32">
               <v-img avatar src="/storage/graphics/insta_64x64.png"/>
             </v-avatar>
           </a>
           <a href="https://twitter.com/WeStore2" target="_blank" style="text-decoration: none">
             <v-avatar size="32">
               <v-img avatar src="/storage/graphics/twitter_64x64.png"/>
             </v-avatar>
           </a>
           <a href="https://www.pinterest.com/westorero/" target="_blank" style="text-decoration: none">
             <v-avatar size="32">
               <v-img avatar src="/storage/graphics/pinterest_64x64.png"/>
             </v-avatar>
           </a>
           <a href="https://plus.google.com/u/4/116658146234010767725" target="_blank" style="text-decoration: none">
             <v-avatar size="32">
               <v-img avatar src="/storage/graphics/google_64x64.png"/>
             </v-avatar>
           </a>
     <v-spacer></v-spacer>
         <v-btn color="indigo darken-1" light :loading="loadingSend" :disabled="!contact_form.accepted" @click.native="send_message()"><div style="color: white">Trimite</div></v-btn>
       </v-card-actions>
     </v-card>
   </v-dialog>
    <v-divider/>
  </v-list>
  <v-flex xs12 mx-2>
    <v-card elevation-20 hover light class="white my-2 mx-2 animated bounceInLeft delay-1s" style="border-radius: 1.5rem; width: 95%; position: fixed; bottom: 0; left: 0;">
      <v-card-actions>
        <h4>Powered by Zesoft</h4>
        <v-spacer></v-spacer>
        <v-avatar size="32">
          <v-img avatar src="https://scontent.fotp3-3.fna.fbcdn.net/v/t1.0-1/p200x200/18765679_765839250256669_3963507997773192840_n.png?_nc_cat=111&oh=f35bf1cc639cb128a99283874c930490&oe=5C178AC1"/>
        </v-avatar>
        <v-avatar size="32" style="margin-left: -0.75rem">
          <img src="/icons/icon-36.png">
        </v-avatar>
      </v-card-actions>
    </v-card>
  </v-flex>
</v-navigation-drawer>
</template>
<script>
import { mapGetters } from 'vuex'
import Form from 'vform'
import LoginWithFacebook from '../components/LoginWithFacebook'
export default {
  name: 'Drawer',
  components: {
    LoginWithFacebook
  },
  data () {
    return {
      contact_form: new Form({
        email: '',
        subject: '',
        message: '',
        secret: '',
        accepted: false,
      }),
      clipped: false,
      loadingSend: false,
      fixed: false,
      tabs: null,
      guest: 'In vizita...',
      contact: false,
      rname: '',
      valid: true,
        subjectRules: [
          v => !!v || 'Va rugam introduceti un subiect',
          v => (v && v.length <= 255) || 'Subiectul poate avea maxim 255 de caractere'
        ],
        messageRules: [
          v => !!v || 'Va rugam introduceti un mesaj',
          v => (v && v.length <= 512) || 'Mesajul poate avea maxim 255 de caractere'
        ],
        acceptedRules: [
          v => !!v || 'Va rugam acceptati pentru a continua'
        ],
        emailRules: [
          v => !!v || 'Va rugam introduceti o adresa de email',
          v => /.+@.+/.test(v) || 'Adresa de email nu este valida'
        ],
      title: 'WeStore'
    }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
  created () {
    if(this.user)
    {
      this.contact_form.email = this.user.email
      this.contact_form.accepted = this.user.accepted_gdpr
    }
  },
  watch: {
    '$route.name': function()
    {
      this.rname = this.$route.name
    },
    'user': function()
    {
      if(this.user)
      {
        this.contact_form.email = this.user.email
        this.contact_form.accepted = this.user.accepted_gdpr
      }
      else {
        this.contact_form.email = ''
        this.contact_form.accepted = false
      }
    }
  },
  methods: {
    async logout (){
      const snackbar = {
        value: true,
        message: `La revedere ${this.user.name}  `,
        type: 'indigo',
        avatar: this.user.avatar,
        icon: 'close',
        mode: '',
        timeout: 6000
      }
      // Log out the user.
      await this.$store.dispatch('auth/logout')
      await this.$store.dispatch('navi/setSnackbar', snackbar)

      // Redirect to home.
      this.$router.push({ name: 'home' })
    },
    async send_message()
    {
      this.loadingSend = true
      if (this.$refs.contact_form.validate()) {

        const { data } = await this.contact_form.post('/api/contact')
        if (data.success === true)
        {
            this.contact_form.email = ''
            this.contact_form.subject = ''
            this.contact_form.message = ''
            this.$store.state.navi.contactDialog = false
            if(!this.user)
            this.contact_form.accepted = false
          const success_snackbar = {
            value: true,
            message: data.message,
            type: 'indigo',
            avatar: false,
            icon: 'send',
            mode: '',
            timeout: 2000
          }
          await this.$store.dispatch('navi/setSnackbar', success_snackbar)

        }
        else {
          this.contact = false
          const error_snackbar = {
            value: true,
            message: data.message,
            type: 'error',
            avatar: false,
            icon: 'close',
            mode: '',
            timeout: 2000
          }
          await this.$store.dispatch('navi/setSnackbar', error_snackbar)
        }
        }
        else {
          const snackbar = {
            value: true,
            message: `Corectati erorile pentru a putea trimite mesajul`,
            type: 'error',
            avatar: false,
            icon: 'close',
            mode: '',
            timeout: 2000
          }
          await this.$store.dispatch('navi/setSnackbar', snackbar)
        }
        this.loadingSend = false
    },
    isHere(route)
    {
      if(!this.contact)
      if(this.$route.name.indexOf(route) > 0)
      {
          return true

      }
      else {
          return false
      }

    }
  }
}
</script>
