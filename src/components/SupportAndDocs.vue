<template>
    <div>
        <el-row>
            <el-col v-for="(item, i) in items" :key="i" :xs="24" :md="8">
              <div class="ninja_countdown_docs_wrap">
                <img :src="assets_url+item.img" alt="" />
                <div class="ninja_countdown_docs_title">
                  <h3>{{ item.title }}</h3>
                </div>
                <div class="ninja_countdown_docs_description">
                  <p>
                    {{ item.des }}
                  </p>
                  <a
                      target="_blank"
                      class="el-button el-button--mini is-plain"
                      :href="item.url"
                      type="info"
                  >{{ item.btn }}</a
                  >
                </div>
              </div>
            </el-col>
        </el-row>
    </div>
</template>

<script>
export default {
    
    data() {
        return {
            assets_url: window.NinjaWhatsappAdmin.assets_url,
            items: {
                support1: {
                    title: 'Need Help?',
                    des: 'Stuck with something? Get help from Our EXPERTS.',
                    url: 'https://fluentmanagement.fluentpos.com/support',
                    img: '/images/support/support.png',
                    btn: 'Contact Support'
                },
                support2: {
                    title: 'Love this Plugin?',
                    des: 'Please write a review. We appreciate it!',
                    url: 'https://fluentmanagement.fluentpos.com/support',
                    img: '/images/support/heart.png',
                    btn: 'Write a Review'
                },
                support3: {
                    title: 'Found a Bug?',
                    des: 'Please report us. We will fix it as soon as possible',
                    url: 'https://fluentmanagement.fluentpos.com/support',
                    img: '/images/support/bug.png',
                    btn: 'Let us know'
                }
            }
        }
    }

}
</script>