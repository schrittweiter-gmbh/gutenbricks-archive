import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { SelectControl } from '@wordpress/components';
import { useSelect, useDispatch } from '@wordpress/data';
import { registerPlugin } from '@wordpress/plugins';
import { __ } from '@wordpress/i18n';

const ArchiveTemplatePanel = () => {
    const archiveType = useSelect(select => {
        return select('core/editor').getEditedPostAttribute('meta')?._gb_archive_type;
    }, []);

    const { editPost } = useDispatch('core/editor');

    // Format options for SelectControl
    const formatOptions = () => {
        const archiveOptions = window.gbArchiveOptions;
        let formattedOptions = [
            { value: '', label: __('Select Archive Type', 'gutenbricks-archive') }
        ];

        Object.entries(archiveOptions).forEach(([groupKey, group]) => {
            // Add group label as disabled option
            formattedOptions.push({
                value: '',
                label: group.label,
                disabled: true
            });

            // Add group options
            group.options.forEach(option => {
                formattedOptions.push({
                    value: option.value,
                    label: `— ${option.label}`  // Indent options with em dash
                });
            });
        });

        return formattedOptions;
    };

    return (
        <PluginDocumentSettingPanel
            name="archive-template-panel"
            title={__('Archive Selection', 'gutenbricks-archive')}
            className="archive-template-panel"
        >
            <SelectControl
                label={__('Select Archive Type', 'gutenbricks-archive')}
                value={archiveType}
                options={formatOptions()}
                onChange={(value) => {
                    editPost({
                        meta: {
                            _gb_archive_type: value
                        }
                    });
                }}
            />
        </PluginDocumentSettingPanel>
    );
};

registerPlugin('archive-template-panel', {
    render: ArchiveTemplatePanel,
    icon: 'archive'
});