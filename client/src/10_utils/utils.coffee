class Utils
  @get_arg_names: (func)->
    String(func).match(/\(.*?\)/)[0].replace(/[()]/gi, '').replace(/\s/gi, '').split(',')

  @scroll_array: (arr, offset)->
    arr[offset...arr.length].concat(arr[0...offset])