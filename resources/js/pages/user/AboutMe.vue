<template>
<div class="about-me">
    <a-row>
        <a-col span="12">
            <div class="portfoliocard">
                <div class="coverphoto"></div>
                <div class="profile_picture" :style="{backgroundImage: 'url('+(user.avatar ? user.avatar : '/images/default-avatar.webp')+')'}"></div>
                <div class="left_col">
                    <div class="followers">
                        Điểm <a-icon type="trophy"></a-icon>
                        <div class="follow_count">{{user.score}}</div>
                    </div>
                    <div class="followers">
                        Cấp độ
                        <a-icon type="sketch" />
                        <div class="follow_count">
                            <a-tooltip placement="top">
                                <template slot="title">
                                    <span>{{currentRank.title}}</span>
                                </template>
                                <img @click="showMedalModal()" class="rank-icon" :src="currentRank.image" />
                            </a-tooltip>

                        </div>
                    </div>
                </div>
                <div class="right_col">
                    <h2 class="name">{{user.full_name}}</h2>
                    <ul class="contact_information">
                        <li>
                            <a-icon type="user"></a-icon> {{user.name}}
                        </li>
                        <li>
                            <a-icon type="mail"></a-icon> {{user.email}}
                        </li>
                    </ul>
                    <div style="text-align: center;margin-top: 20px;">
                        <a-button type="dashed" icon="form" size="large" @click="showEditProfileModal">
                            Thay đổi thông tin
                        </a-button>
                    </div>
                    <img src="/images/about-footer.gif" />
                </div>
            </div>
        </a-col>
        <a-col span="12">
            <div class="statistics">
                <a-row>
                    <a-col span="10" class="left-statistics">
                        <h3>Thông số</h3>
                        <div>
                            <p>Tổng số từ: <b>{{statistics.total_word}}</b></p>
                            <p>Số danh mục: <b>{{statistics.total_category}}</b> danh mục</p>
                            <p>Đang chia sẻ: <b>{{statistics.total_sharing_category}}</b> danh mục</p>
                            <p>Lượt tải: <b>{{statistics.download_time}}</b></p>
                        </div>
                    </a-col>
                    <a-col span="14">
                        <pie-chart :data="chartData" :options="chartOptions"></pie-chart>
                    </a-col>
                </a-row>
            </div>

            <div class="chart">
                <line-chart />
            </div>
        </a-col>
    </a-row>
    <a-modal v-model="medalModalVisible" title="Huy hiệu" width="650px" footer="">
        <a-row>
            <a-col :span="12" v-for="rank in ranks" :key="rank">
                <div class="rank">
                    <img :src="rank.image" width="70px" />
                    <div class="rank-desc">
                        <b>{{rank.title}}</b>
                        -
                        Điểm {{rank.start_score}} ~ {{rank.end_score}}
                    </div>
                </div>
            </a-col>
        </a-row>
    </a-modal>
    <a-modal v-model="editProfileModalVisible" title="Sửa thông tin" width="650px" footer="">
        <a-row>
            <a-col :span="8">
                <div>
                    <img :style="{width: '200px', height: '200px'}" :src="tempImageUrl ? tempImageUrl : user.avatar" />
                    <div class="edit-avatar-btn" @click="chooseImage">
                        {{tempImageUrl ? 'Hủy thay đổi' : 'Đổi hình nền'}}
                    </div>
                    <input type="file" ref="image" @change="onImageChange" style="display: none">
                </div>
            </a-col>
            <a-col :span="16" class="profile-edit">
                <a-input class="profile-input" v-model="updatedUser.full_name" size="large" addonBefore="Tên">
                    <a-icon slot="prefix" type="user" />
                </a-input>
                <a-input class="profile-input" v-model="updatedUser.email" size="large" addonBefore="Email">
                    <a-icon slot="prefix" type="mail" />
                </a-input>
                <a-checkbox class="profile-input" size="large" @change="handleChangePasswordMode">
                    Đổi mật khẩu
                </a-checkbox>
                <div v-show="changePasswordMode">
                    <a-input-password v-model="updatedUser.password" :disabled="!changePasswordMode" class="profile-input" size="large" placeholder="Nhập mật khẩu mới" />
                    <a-input-password v-model="updatedUser.re_password" :disabled="!changePasswordMode" class="profile-input" size="large" placeholder="Nhập lại mật khẩu" />
                </div>
                <div class="edit-profile-btn-group">
                    <a-button type="primary" @click="submit">
                        Lưu
                    </a-button>
                    <a-button type="dashed" @click="handeCloseEditProfile">
                        Thoát
                    </a-button>
                </div>
            </a-col>
        </a-row>
    </a-modal>
</div>
</template>

<script>
import rf from './../../requests/RequestFactory';
import PieChart from './Chart/PieChart';
import LineChart from './Chart/LineChart';
export default {
    components: {
        PieChart,
        LineChart
    },
    data() {
        return {
            medalModalVisible: false,
            editProfileModalVisible: false,
            changePasswordMode: false,
            currentRank: {},
            tempImage: {},
            tempImageUrl: '',
            editImageMode: false,
            statistics: {
                total_word: 0,
                total_category: 0,
                total_sharing_category: 0,
                download_time: 0
            },
            ranks: [{
                title: 'Trái Đất',
                start_score: 0,
                end_score: 100,
                image: '/images/rank/earth.png'
            }, {
                title: 'Mặt Trăng',
                start_score: 101,
                end_score: 200,
                image: '/images/rank/moon.png'
            }, {
                title: 'Sao Thuỷ',
                start_score: 201,
                end_score: 300,
                image: '/images/rank/mercury.png',
            }, {
                title: 'Sao Hoả',
                start_score: 301,
                end_score: 400,
                image: '/images/rank/mars.png'
            }, {
                title: 'Sao Thổ',
                start_score: 401,
                end_score: 500,
                image: '/images/rank/saturn.png'
            }, {
                title: 'Sao Mộc',
                start_score: 501,
                end_score: 600,
                image: '/images/rank/jupiter.png'
            }, {
                title: 'Lỗ Đen',
                start_score: 601,
                end_score: 700,
                image: '/images/rank/blackHole.png'
            }, {
                title: 'Mặt trời',
                start_score: 701,
                end_score: '',
                image: '/images/rank/sun.png'
            }],
            user: {
                email: '',
                full_name: '',
                score: 100
            },
            updatedUser: {
                email: '',
                full_name: '',
                password: '',
                re_password: '',
                avatar: ''
            }
        }
    },
    methods: {
        showMedalModal() {
            this.medalModalVisible = true;
        },
        showEditProfileModal() {
            this.editProfileModalVisible = true;
        },
        handleChangePasswordMode(e) {
            this.changePasswordMode = e.target.checked;
        },
        handeCloseEditProfile() {
            this.editProfileModalVisible = false;
        },
        onImageChange(e) {
            const file = e.target.files[0];
            this.tempImage = file;
            this.tempImageUrl = URL.createObjectURL(file);
            if (this.tempImageUrl) {
                this.editImageMode = true;

            }
        },
        chooseImage() {
            if (this.tempImageUrl) {
                this.tempImage = {};
                this.tempImageUrl = '';
            } else {
                this.$refs.image.click();
            }
        },
        submit() {
            let formData = new FormData();
            if (this.tempImageUrl) {
                formData.append('file', this.tempImage);
            }
            formData.append('email', this.updatedUser.email);
            formData.append('full_name', this.updatedUser.full_name);
            if (this.changePasswordMode) {
                formData.append('password', this.updatedUser.password);
                formData.append('password_confirmation', this.updatedUser.re_password);
            }
            rf.getRequest('UserRequest').updateProfile(formData).then(res => {
                this.editProfileModalVisible = false;
                this.getUserInfo();
                this.changePasswordMode = false;
                this.$notification.success({
                    message: 'Thành công',
                    description:
                    'Thông tin của bạn đã được cập nhật thành công.',
                });
            })
        },
        getUserInfo() {
            rf.getRequest('UserRequest').getCurrentUser().then(res => {
                this.user = res;
                this.updatedUser.email = res.email;
                this.updatedUser.full_name = res.full_name;
                for (let rank of this.ranks) {
                    if (this.user.score >= rank.start_score && this.user.score <= rank.end_score) {
                        this.currentRank = rank;
                        break;
                    } else {
                        this.currentRank = this.ranks.slice(-1).pop();
                    }
                }
            });
        }
    },
    mounted() {
        rf.getRequest('UserRequest').getStatistics().then(res => {
            this.statistics = res;
        });
        this.getUserInfo();
    },
}
</script>

<style lang="scss">
#doughnut-chart {
    height: 300px !important;
    width: 300px !important;
    color: white !important;
}

#line-chart {
    height: 300px !important;
}
</style>
<style lang="scss" scoped>
@-webkit-keyframes rotation {
    from {
        -webkit-transform: rotate(0deg);
    }

    to {
        -webkit-transform: rotate(359deg);
    }
}

.profile-edit {
    .edit-profile-btn-group {
        text-align: right;
    }
}

.profile-input {
    padding: 10px;
}

.rank-icon {
    cursor: pointer;
    width: 50px;
    -webkit-animation: rotation 12s infinite linear;
}

.edit-avatar-btn {
    text-align: center;
    background-color: rgb(81 76 76 / 63%);
    color: white;
    padding: 3px;
    cursor: pointer;
}

.rank {
    margin: 10px;
    padding: 10px;
    background-color: #f0f0f0;
    border-radius: 5px;

    .rank-desc {
        display: inline;
    }
}

.statistics {
    width: 100%;
    height: 300px;
    background-color: #ffffffed;
    margin-top: 50px;
    border-radius: 15px;
    box-shadow: inset 0px 3px 20px rgba(255, 255, 255, 0.3), 1px 0px 2px rgba(255, 255, 255, 0.7);
}

.left-statistics {
    padding: 20px;
}

.chart {
    width: 100%;
    height: 300px;
    background-color: #ffffffeb;
    margin-top: 10px;
    border-radius: 15px;
    box-shadow: inset 0px 3px 20px rgba(255, 255, 255, 0.3), 1px 0px 2px rgba(255, 255, 255, 0.7);
}

.about-me {
    padding: 30px;
    background-image: url('/images/about-me.jpg');
    background-size: cover;
}

a.nostyle {
    color: inherit;
    text-decoration: none;
    padding: 0;
    margin: 0;
}

div.portfoliocard {
    position: relative;
    height: 600px;
    width: 500px;
    background: rgba(255, 255, 255, 1);
    border: 1px solid rgba(0, 0, 0, 0.7);
    box-shadow: 0px -1px 3px rgba(0, 0, 0, 0.1),
        0px 2px 6px rgba(0, 0, 0, 0.5);
    border-radius: 6px;
    margin: 10% auto;
    overflow: hidden;
    z-index: 100;
}

div.portfoliocard div.coverphoto {
    width: 100%;
    height: 120px;
    background: url('/images/profile-cover.jpeg');
    background-size: cover;
    background-position: center center;
    border-top-right-radius: 5px;
    border-top-left-radius: 5px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    box-shadow: inset 0px 3px 20px rgba(255, 255, 255, 0.3),
        1px 0px 2px rgba(255, 255, 255, 0.7);
    z-index: 99;
}

div.portfoliocard div.left_col,
div.portfoliocard div.right_col {
    float: left;
    height: 540px;
}

div.portfoliocard div.left_col {
    width: 40%;
    padding-top: 85px;
    box-sizing: border-box;
}

div.portfoliocard div.right_col {
    width: 60%;
    background: rgba(245, 245, 245, 1);
    border-left: 1px solid rgba(230, 230, 230, 1);
    box-shadow: inset 0px 1px 1px rgba(255, 255, 255, 0.7);
    margin-left: -1px;
    border-bottom-right-radius: 5px;
}

div.portfoliocard div.profile_picture {
    width: 110px;
    height: 110px;
    background: rgba(255, 255, 255, 1);
    position: absolute;
    top: 65px;
    left: 40px;
    border-radius: 100%;
    // background-image: url('https://www.iconfinder.com/data/icons/professions-2-2/151/51-512.png');
    background-size: 100% 100%;
    padding: 7px;
    border: 4px solid rgba(255, 255, 255, 1)
}

div.portfoliocard div.right_col h2.name {
    font-size: 30px;
    font-weight: 300;
    color: rgba(30, 30, 30, 1);
    padding: 0;
    margin: 20px 10px 0px 30px;
}

div.portfoliocard div.right_col h3.location {
    font-size: 15px;
    font-weight: 300;
    color: rgba(170, 170, 170, 1);
    padding: 0;
    margin: -5px 10px 10px 30px;
}

div.portfoliocard ul.contact_information {
    margin-top: 20px;
    padding-left: 30px;
    list-style-type: none;
}

div.portfoliocard ul.contact_information li {
    height: 35px;
    width: 280px;
    line-height: 25px;
    font-weight: 300;
    font-size: 15px;
    color: rgba(140, 140, 140, 1);
    text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.8);
    padding: 5px 0px;
    background-repeat: no-repeat;
    background-size: 18px 18px;
    border-bottom: none;
    cursor: default;
}

div.portfoliocard div.followers,
div.portfoliocard div.following {
    margin: 15px 0px 0px 35px;
    font-weight: 300;
    font-size: 16px;
    color: rgba(30, 30, 30, 1);
}

div.portfoliocard div.follow_count {
    font-weight: 400;
    font-size: 25px;
    color: rgba(140, 140, 140, 1);
}
</style>
