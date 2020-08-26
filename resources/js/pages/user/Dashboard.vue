<template>
<div v-drag-and-drop:options="options">
  <!-- optional renderless component -->
  <vue-draggable-group
    v-for="group in groups"
    v-model="group.items"
    :groups="groups"
    :key="group.id"
    :data-id="group.id"
    @change="onGroupsChange"
  >
    <ul>
      <li
        v-for="item in group.items"
        :key="item.id"
        :data-id="item.id"
      >
        <label v-text="item.name"></label>
      </li>
    </ul>
  </vue-draggable-group>
</div>
</template>

<script>
export default {
  
  data() {
    return {
      groups: [
          {
              id: 1,
              items: [
                  {
                      id: 1,
                      name: "hihi"
                  }
              ]
          },
           {
              id: 1,
              items: [
                  {
                      id: 1,
                      name: "hihi"
                  }
              ]
          }
      ],

      dropGroups: [
        {
          name: 'Business Team',
          children: []
        },
        {
          name: 'Tech Dept',
          children: []
        },
        {
          name: 'Marketing Dept',
          children: []
        }
      ]
    }
  },
}
</script>