import { mount} from '@vue/test-utils';
import { expect, test } from 'vitest';

import ChatBubbleComponent from '@/components/chat/ChatBubbleComponent.vue';

const dateSent = '2026-01-19T12:00:00.000000Z';
const dateSentResult = '19/01/2026, 12:00:00';
const message = 'This is a testing message';
const sentBy = 'emil_chigu';

const messageSelector = '#message';
const sentBySelector = 'span#sent-by';
const sentDateSelector = '#sent-date';


test("mount my chat bubble", async () => {
    const wrapper = mount(ChatBubbleComponent, {
        props: {
            message: message,
            mine:true,
            dateSent: dateSent,
            sentBy: sentBy
        },
    });

    expect(wrapper.find(messageSelector).text()).toContain(message);
    expect(wrapper.find(sentBySelector).exists()).toBe(false);
    expect(wrapper.find(sentDateSelector).text()).toContain(dateSentResult);
})

test('mount other chat bubble', async () => {
    const wrapper = mount(ChatBubbleComponent, {
        props: {
            message: message,
            mine: false,
            dateSent: dateSent,
            sentBy: sentBy,
        },
    });

    expect(wrapper.find(messageSelector).text()).toContain(message);
    expect(wrapper.find(sentBySelector).exists()).toBe(true);
    expect(wrapper.find(sentBySelector).text()).toBe(sentBy);
    expect(wrapper.find(sentDateSelector).text()).toContain(dateSentResult);
});