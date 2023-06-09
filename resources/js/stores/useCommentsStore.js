import axios from 'axios';
import { defineStore } from 'pinia';

export const useCommentsStore = defineStore('comments', {
    state: () => ({
        comments: [],
        currentUser: null
    }),
    getters: {
        getComments: (state) => state.comments,
        getCurrentUser: (state) => state.currentUser
    },
    actions: {
        setCurrentUser(user) {
            this.currentUser = user;
        },

        async fetchComments(post_id) {
            try {
                const response = await axios.get(`/api/comments/${post_id}`);
                this.comments = response.data;
            } catch (error) {
                console.log(error);
            }
        },
        async storeComment(user_id, post_id, body) {
            try {
                const response = await axios.post('/api/add/comment', {
                    user_id,
                    post_id,
                    body
                });
                this.comments.unshift(response.data);
            } catch (error) {
                console.log(error);
            }
        },
        async deleteComment(commentId) {
            try {
                await axios.delete(`/api/comments/${commentId}`);
                this.comments = this.comments.filter(comment => comment.id !== commentId);
            } catch (error) {
                console.log(error);
            }
        }
    }

});
