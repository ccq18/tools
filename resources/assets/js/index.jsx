/**
 * Created by mac on 2017/11/8.
 */
import {Button} from 'antd-mobile';
import ReactDOM from 'react-dom';
import React from 'react';
// ReactDOM.render(<Button>Start</Button>,   document.getElementById('app'));

let mountNode = document.getElementById('app');

import {Flex, WhiteSpace, WingBlank} from 'antd-mobile';

const PlaceHolder = props => (
    <div
        style={{
            backgroundColor: '#ebebef',
            color: '#bbb',
            textAlign: 'center',
            height: '30px',
            lineHeight: '30px',
            width: '100%',
        }}
        {...props}
    >Item</div>
);

const FlexExample = () => (
    <div className="flex-container">
        <WingBlank size="lg">
            <div className="sub-title">Basic</div>
            <Flex>
                <Flex.Item><PlaceHolder /></Flex.Item>
                <Flex.Item><PlaceHolder /></Flex.Item>
            </Flex>
            <WhiteSpace size="lg"/>
            <Flex>
                <Flex.Item><PlaceHolder /></Flex.Item>
                <Flex.Item><PlaceHolder /></Flex.Item>
                <Flex.Item><PlaceHolder /></Flex.Item>
            </Flex>
            <WhiteSpace size="lg"/>
            <Flex>
                <Flex.Item><PlaceHolder /></Flex.Item>
                <Flex.Item><PlaceHolder /></Flex.Item>
                <Flex.Item><PlaceHolder /></Flex.Item>
                <Flex.Item><PlaceHolder /></Flex.Item>
            </Flex>
            <WhiteSpace size="lg"/>

            <div className="sub-title">Wrap</div>
            <Flex wrap="wrap">
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
            </Flex>
            <WhiteSpace size="lg"/>

            <div className="sub-title">Align</div>
            <Flex justify="center">
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
            </Flex>
            <WhiteSpace />
            <Flex justify="end">
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
            </Flex>
            <WhiteSpace />
            <Flex justify="between">
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline"/>
            </Flex>

            <WhiteSpace />
            <Flex align="start">
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline small"/>
                <PlaceHolder className="inline"/>
            </Flex>
            <WhiteSpace />
            <Flex align="end">
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline small"/>
                <PlaceHolder className="inline"/>
            </Flex>
            <WhiteSpace />
            <Flex align="baseline">
                <PlaceHolder className="inline"/>
                <PlaceHolder className="inline small"/>
                <PlaceHolder className="inline"/>
            </Flex>
        </WingBlank>
    </div>
);

ReactDOM.render(<FlexExample />, mountNode);
