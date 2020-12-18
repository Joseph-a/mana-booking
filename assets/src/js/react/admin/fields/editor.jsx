import React, { Component } from 'react'
import { __ } from '@wordpress/i18n';
import ReactQuill from 'react-quill';

export default class TextEditor extends Component {
    constructor(props) {
        super(props)
        this.state = {
            text: props.savedValue[props.info.fieldIndex] || "",
        }
        this.settings = {
            modules: {
                toolbar: [
                    [{ 'font': [] }, { 'header': [1, 2, 3, 4, false] }],
                    [{ size: [] }],
                    ['bold', 'italic', 'underline', 'strike', 'blockquote'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' },
                    { 'indent': '-1' }, { 'indent': '+1' }],
                    ['link', 'image'],
                    ['clean']
                ],
            },
            formats: [
                'header', 'font', 'size',
                'bold', 'italic', 'underline', 'strike', 'blockquote',
                'list', 'bullet', 'indent',
                'link', 'image'
            ]
        }
        this.handleChange = this.handleChange.bind(this);

    }
    handleChange(value) {
        const { info } = this.props;
        this.setState({ text: value })
        this.props.onFieldChanged(info.fieldIndex, value);
    }

    render() {
        const { modules, formats } = this.settings;
        return (
            <div className="mana-text-editor">
                <ReactQuill theme="snow"
                    modules={modules}
                    formats={formats}
                    onChange={this.handleChange}
                />
            </div>
        )
    }
}