<template>
  <div class="text-xs-center">
    <v-bottom-sheet v-model="$store.state.navi.loginSheet">
      <v-spacer/>
      <v-btn slot="activator" icon style="margin-bottom: -0.75em; margin-right: -0.75em">
        <v-icon>account_circle</v-icon>
      </v-btn>
      <v-list>
        <template>
          <v-list-tile v-if="!$store.state.auth.accepted">
            <v-checkbox
              v-model="$store.state.auth.accepted"
              required
              @change="set_accept"/>
            <v-list-tile-title><div style="font-size: 0.95em">Sunt de acord cu  <a :href="terms_url">termenii si conditiile</a></div></v-list-tile-title>
          </v-list-tile>
          <v-list-tile v-else="">
            <v-list-tile-avatar>
              <v-avatar size="32px" tile>
                <img
                  :src="`https://i.imgur.com/X3qTp20.png`"
                  :alt="`WeStore`"
                >
              </v-avatar>
            </v-list-tile-avatar>
            <v-list-tile-title><div style="font-size: 0.95em">Conecteaza-te cu:</div></v-list-tile-title>
          </v-list-tile>
          <v-list-tile
            v-for="tile in tiles"
            :key="tile.title"
            @click="login(tile.provider)"
          >
            <v-list-tile-avatar>
              <v-avatar size="32px" tile>
                <img
                  :src="`${tile.img}`"
                  :alt="tile.title"
                >
              </v-avatar>
            </v-list-tile-avatar>
            <v-list-tile-title>{{ tile.title }}</v-list-tile-title>
          </v-list-tile>

        </template>
      </v-list>
    </v-bottom-sheet>
  </div>
</template>

<script>
import Form from 'vform'
import Cookies from 'js-cookie'
import axios from 'axios'
export default {
  name: 'LoginWithFacebook',

  data: () => ({
    form: new Form({
      email: '',
      name: '',
      last_name: '',
      provider: '',
      provider_id: '',
      avatar: '',
      access_token: '',
      refresh_token: '',
      accepted: ''
    }),
    tiles: [
      { img: '/storage/graphics/fb_64x64.png', title: 'Facebook', provider: 'facebook' },
      { img: '/storage/graphics/google_64x64.png', title: 'Google', provider: 'google' }
    ],
    remember: true,
    accepted: Cookies.get('accepted')
  }),
  watch: {
    'form.busy': function()
    {
      if(!this.form.successful)
      {
        let  message  = 'Actiunea dvs. nu a putut fi procesata.'
        if(this.form.errors.has('email'))
        {
          message  = 'WeStore nu are access la adresa dvs. de email pentru a verifica contul.'
          const snackbar = {
            value: true,
            message: message,
            type: 'error',
            avatar: false,
            icon: 'close',
            action: true,
            mode: '',
            timeout: 12000
          }
          this.$store.dispatch('navi/setSnackbar', snackbar)
        }

      }
    },
    '$store.state.navi.init_login': function()
    {
      if(this.$store.state.navi.init_login === true)
      this.login('facebook')
    }
  },
  computed: {
    url: () => `/api/auth`,
    terms_url: () => `http://www.trafic.ro/despre/cookies`
  },
  methods: {
    async set_accept () {
      Cookies.set('accepted', this.$store.state.auth.accepted, { expires: 365 })
    },
    async login ($provider) {
      if (!this.$store.state.auth.accepted) {
        const snackbar = {
          value: true,
          message: `Ati uitat sa acceptati termenii si conditiile`,
          type: 'error',
          avatar: false,
          icon: 'close',
          mode: '',
          timeout: 2000
        }
        await this.$store.dispatch('navi/setSnackbar', snackbar)
      }
      else {
        const hello = this.hello
        let profile = ''
        let permission = true
        await hello($provider).login().then(async () => {
          const authRes = hello($provider).getAuthResponse()
          if($provider === 'facebook'){
            console.log($provider === 'facebook')
            await hello($provider).api('me/permissions').then(function (json) {
              permission = json.data[1].status === 'granted'
              if(!permission)
              {
                let delete_url = `https://graph.facebook.com/v2.9/me/permissions?access_token=${authRes.access_token}`
                axios.delete(delete_url)
              }
            })
          }

            this.form.provider = $provider
            this.form.access_token = authRes.access_token
            this.form.refresh_token = authRes.expires_in
            await hello($provider).api('me').then(function (json) {
              profile = json
            })
            this.form.email = profile.email
            this.form.name = profile.first_name
            this.form.last_name = profile.last_name
            this.form.provider_id = profile.id
            this.form.accepted = this.$store.state.auth.accepted
            this.form.avatar = profile.picture

        })
        if(permission){
          const { data } = await this.form.post(this.url)
          // Save the token.
          if (data.token) {
            this.$store.dispatch('auth/saveToken', {
              token: data.token,
              remember: this.remember,
              accepted: this.$store.state.auth.accepted
            })

            // Fetch the user.
            await this.$store.dispatch('auth/fetchUser')
            this.$store.state.navi.init_login = false
            const snackbar = {
              value: true,
              message: `Bun venit ${this.$store.state.auth.user.name}  `,
              type: 'indigo',
              avatar: this.$store.state.auth.user.avatar,
              icon: 'close',
              mode: '',
              timeout: 4000
            }
            await this.$store.dispatch('navi/setSnackbar', snackbar)
            await this.$store.dispatch('navi/setLoginSheet', false)

            // Redirect home.
            //this.$router.push({name: 'home'})
          }
          else {
            const snackbar = {
              value: true,
              message: data.errors,
              type: 'error',
              avatar: false,
              icon: 'close',
              mode: '',
              timeout: 4000
            }
            await this.$store.dispatch('navi/setSnackbar', snackbar)
          }}
          else {
            let message  = 'WeStore nu are access la adresa dvs. de email pentru a verifica contul.'
            const reinit_snackbar = {
              value: true,
              message: message,
              type: 'error',
              avatar: false,
              icon: 'close',
              action: true,
              mode: '',
              timeout: 12000
            }
            this.$store.dispatch('navi/setSnackbar', reinit_snackbar)
          }

      }
    }
  }
}
</script>
